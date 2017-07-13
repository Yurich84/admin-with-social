<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    public function __construct(Request $request)
    {
        if (\Auth::check()) {
            if (!is_null(\Auth::user()->theme)) {
                \Theme::set(\Auth::user()->theme->name);
            }else{
                \Theme::set('default');
            }
        }

        // url with token
        if($request->has('token')) {
            redirect()->route('user.loginuser', $request->input('token'))->send()
                ->with('url', $request->fullUrl());
        }
    }

}
