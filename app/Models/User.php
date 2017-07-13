<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * get user theme
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme()
    {
        return $this->belongsTo('App\Models\Theme');
    }


    public function socials()
    {
        return $this->hasMany('App\Models\Social', 'user_id', 'id');
    }



    public static function createBySocialProvider($providerUser)
    {
        return self::create([
            'email' => $providerUser->getEmail(),
            'name' => $providerUser->getName(),
        ]);
    }



    public static $rules = [
        'name'                  => 'required',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|alpha_num|min:5|max:25',
        'password_confirmation' => 'required|same:password'
    ];

    public static $messages = [
        'name.required'         => 'Укажите Логин',
        'email.required'        => 'Укажите Email',
        'email.email'           => 'Неверный email',
        'email.unique'          => 'Пользователь с таким почтовым ящиком уже зарегестрирован',
        'password.required'     => 'Укажите пароль',
        'password.min'          => 'Пароль должен быть больше 5 символов',
        'password.max'          => 'Пароль должен быть меньше 25 символов',
        'password.alpha_num'    => 'Пароль должен содержать только цифры и буквы латынского алфавита',
        'password_confirmation.same'    => 'Пароль и подтвержденный пароль должны совпадать',
        'password_confirmation.required'=> 'Поле Подтвердите пароль обязательно для заполнения.'
    ];


}
