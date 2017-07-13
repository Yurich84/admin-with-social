<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.home.index');
    }

    public function admin()
    {
        return view('backend.admin.home');
    }


    public function manager()
    {
        return view('backend.user.home');
    }

    public function test()
    {
        $data['user'] = 'Yurko';

        \Mail::send('mail.test', $data, function ($message) use ($data) {
            $message->subject('Hello ', $data['user'])
                ->to(config('site.email'));
//                ->replyTo($user['email']);
        });
    }

    public function mail()
    {
        \Mail::raw("Testing", function ($message) {
            $message->to('Shaman_84@mail.ru')
                ->subject('LaravelGMail App!');
        });
    }


}
