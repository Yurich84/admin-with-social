<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use \Auth;
use Illuminate\Http\Request;
use App\Services\ActivationService;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/backend';

    protected $activationService;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService, Request $request)
    {
        parent::__construct($request);
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'activate', 'loginuser']]);
        $this->activationService = $activationService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }



    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin()
    {
        $email       = Input::get('email');
        $password   = Input::get('password');
        $remember   = Input::get('remember');

        if(Auth::attempt([
            'email'     => $email,
            'password'  => $password
        ], $remember == 1 ? true : false))
        {
            if( Auth::user()->hasRole(['customer', 'social', 'registered', 'unconfirmed'] ) )
            {
                return redirect()->route('backend.user.occaunt');
            }

            if( Auth::user()->hasRole(['admin', 'manager']) )
            {
                return redirect()->route('backend.user.admin');
            }

        }
        else
        {
            return redirect()->back()
                ->with('message','Неправильный email или пароль')
                ->with('status', 'danger')
                ->withInput();
        }

    }

    public function logout()
    {
        \Auth::logout();

        return redirect()->route('auth.login')
            ->with('status', 'success')
            ->with('message', 'Розлогинены');

    }


    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, User::$rules, User::$messages);
        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->create($request->all());
        $this->activationService->sendActivationMail($user);

        //Assign Role
        $role = Role::whereName('unconfirmed')->first();
        $user->attachRole($role);

        return redirect()->route('auth.login')
            ->with('status', 'success')
            ->with('message', 'Регистрация завершена. Чтобы активировать аккаунт пройдите по ссылке в письме.');


    }

    public function activate($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect($this->redirectPath())
                ->with('status', 'success')
                ->with('message', 'Вы активированы');;
        }
        abort(404);
        return;
    }

    public function loginuser($token)
    {

        $url = session('url');

        parse_str(parse_url($url, PHP_URL_QUERY), $new_query);

        unset($new_query['token']);

        $new_url = parse_url($url, PHP_URL_PATH) . '/?' . http_build_query($new_query);

        if($user = User::where('token', $token)->first()){
            Auth::login($user);
            return redirect(url($new_url));
        }
        return redirect()->guest('login')->with('status', 'danger')->with('message','Неверный или устаревший токен');

    }


}
