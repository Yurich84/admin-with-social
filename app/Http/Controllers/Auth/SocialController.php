<?php

namespace App\Http\Controllers\Auth;

use App\Models\Social;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Request;

class SocialController extends Controller
{
    public function login($provider, Request $request)
    {
        $user_id = null;
        if($request->has('user_id')){
            $user_id = $request->input('user_id');
        }
        $request->session()->flash('user_id', $user_id);
        return Socialite::with($provider)->redirect();
    }



    public function callback(Social $social, $provider)
    {
        $user_id = session('user_id');
        $driver   = Socialite::driver($provider);
        $user = $social->createOrGetUser($driver, $provider, $user_id);
        \Auth::login($user, true);


        return redirect()->route('backend.home');
    }
}
