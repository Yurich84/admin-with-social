<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.home.index');
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
