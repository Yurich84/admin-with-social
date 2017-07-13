<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

$a = 'auth.';
Route::get('/login',            ['as' => $a . 'login',          'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login',           ['as' => $a . 'login-post',     'uses' => 'Auth\AuthController@postLogin']);
Route::get('/register',         ['as' => $a . 'register',       'uses' => 'Auth\AuthController@getRegister']);
Route::post('/register',        ['as' => $a . 'register-post',  'uses' => 'Auth\AuthController@postRegister']);

Route::get('/activation/{token}', ['as' => 'user.activate', 'uses' => 'Auth\AuthController@activate']);
Route::get('/loginuser/{token}', ['as' => 'user.loginuser', 'uses' => 'Auth\AuthController@loginuser']);

Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);

Route::get('/social_login/{provider}', 'Auth\SocialController@login')->name('soc.login');
Route::get('/social_login/callback/{provider}', 'Auth\SocialController@callback')->name('soc.callback');



/**
* FRONTEND
*/
Route::group(['namespace' => 'Frontend'], function () {

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

});


/**
 * BACKEND
 */
Route::group(['prefix' => 'backend', 'namespace' => 'Backend', 'middleware' => 'auth'], function () {

    /**
     * ADMIN for admin and manager role user
     */
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|manager']], function () {
        Route::get('/', [
            'uses' => 'UserController@admin',
            'as' => 'backend.user.admin',
        ]);

        Route::get('userlist', [
            'uses' => 'UserController@userlist',
            'as' => 'backend.user.list',
        ]);

        Route::get('updaterole', [
            'uses' => 'UserController@updaterole',
            'as' => 'backend.user.updaterole',
        ]);

        Route::get('del/{id}', [
            'uses' => 'UserController@del',
            'as' => 'backend.user.del',
        ]);

        Route::get('loginbyuser/{id}', [
            'uses' => 'UserController@loginbyuser',
            'as' => 'backend.admin.loginbyuser',
        ]);

        Route::get('tokenforuser/{id}', [
            'uses' => 'UserController@tokenforuser',
            'as' => 'backend.admin.tokenforuser',
        ]);

    });


    Route::get('/', [
        'uses' => 'HomeController@index',
        'as' => 'backend.home',
    ]);

    Route::get('occaunt', [
        'uses' => 'UserController@occaunt',
        'as' => 'backend.user.occaunt',
    ]);

    Route::put('changetheme', [
        'uses' => 'ThemeController@changetheme',
        'as' => 'backend.user.changetheme',
    ]);

    Route::put('changeuserinfo', [
        'uses' => 'UserController@change_user_info',
        'as' => 'backend.user.changeuserinfo',
    ]);

    Route::get('/occaunt/delsocial/{user_id}/{provider}', [
        'uses' => 'UserController@delsocial',
        'as' => 'backend.user.delsocial',
    ]);

});