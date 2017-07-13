<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Auth\AuthController;
use App\Models\Role;
use App\Models\User;

use App\Http\Requests;
use App\Services\ActivationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use \Carbon\Carbon;
use \DB;

class UserController extends Controller
{
    public function admin()
    {
        return view('backend.user.admin');
    }

    public function userlist()
    {
        return view('backend.user.list', [
            'users' => User::all(),
            'roles' => Role::all()
        ]);
    }

    public function updaterole(Request $request)
    {
        $user = User::find($request->user_id);
        if(!empty($request->roles)){
            $user->roles()->sync($request->roles); // сохраняем роли
        }else{
            $user->roles()->detach();
        }
        return redirect()->back();
    }

    public function del($user_id)
    {
        $user = User::find($user_id);

        // удаляем связи с ролями
        $user->roles()->sync([]);

        // удаляем связи с соц сетями
        foreach ($user->socials() as $social) {
            $social->destroy();
        }

        // удаляем пользователя
        $user->destroy($user_id);

        return redirect()->back();

    }

    public function loginbyuser($id)
    {
        Auth::login(User::find($id));
        return redirect()->route('backend.user.occaunt');
    }


    public function tokenforuser($user_id)
    {
        $token = hash_hmac('sha256', str_random(40), config('app.key'));
        $user = User::find($user_id);

        $user->token = $token;
        $user->save();

        return redirect()->route('backend.user.list');
    }



    public function occaunt()
    {
        return view('backend.user.occaunt', [
            'user' => Auth::user()
        ]);
    }

    public function change_user_info(Request $request, ActivationService $activationService)
    {
        $user = Auth::user();

        $old_email = $user->email;

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->fill($request->all())->save();

        $success = 'Обновлено';

        if($old_email <> $request->input('email')){

            $user->roles()->sync([]);
            $role = Role::whereName('unconfirmed')->first();
            $user->attachRole($role);

            $activationService->sendActivationMail($user);

            $success = 'Подтвердите почту пройдя по ссылке, которую мы прислали';

            $log = [
                'user_id' => $user->id,
                'event' => 'Смена почты с ' . $old_email . ' на ' . $request->input('email'),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];
            DB::table('user_logs')->insert($log);
        }


        return redirect()->back()->withSuccess($success);
    }

    public function delsocial($user_id, $provider)
    {
        $user = User::find($user_id);

        // удаляем связи с соц сетями
        if( $user->socials()->count() > 1 ){
            $user->socials()->whereProvider($provider)->first()->delete();
        }

        return redirect()->back()->with('status', 'Аккаунт ' . $provider . ' отвязан');

    }

}
