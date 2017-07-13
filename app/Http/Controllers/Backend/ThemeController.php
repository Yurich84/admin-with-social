<?php

namespace App\Http\Controllers\Backend;

use App\Models\Theme;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ThemeController extends Controller
{

    public function getlist()
    {
        return Theme::oldest('name')->pluck('name', 'id')->all();
    }

    public function changetheme(Request $request)
    {
        if($request->input('theme')){
            $user = \Auth::user();
            $user->theme_id = $request->input('theme');
            $user->save();
            return redirect()->route('backend.user.occaunt');
        }else{
            return redirect()->route('backend.user.occaunt');
        }
    }

}
