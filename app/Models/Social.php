<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as UserS;

class Social extends Model
{
    protected $table = 'social_logins';
    protected $fillable = ['user_id', 'social_id', 'provider'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function createOrGetUser($providerObj, $providerName, $user_id = null)
    {

        $providerUser = $providerObj->user();

        $account = Social::whereProvider($providerName)
            ->whereSocialId($providerUser->getId())
            ->first();

        if($user = User::find($user_id)){
            if (!$account) {
                $account = new Social([
                    'social_id' => $providerUser->getId(),
                    'provider' => $providerName]);
                $account->user()->associate($user);
                $account->save();
            }else{
                \Session::flash('status', 'danger');
                \Session::flash('message', 'Этот аккаунт социальной сети используется');
            }

            return $user;
        }

        if ($account) {
            return $account->user;
        } else {

            $account = new Social([
                'social_id' => $providerUser->getId(),
                'provider' => $providerName]);

            $user = User::whereEmail($providerUser->getEmail())->whereNotNull('email')->first();

            if (!$user) {
                $user = User::createBySocialProvider($providerUser);
            }

            // Add role

            if(!$user->hasRole('social')){
                $socialRole = Role::whereName('social')->first();
                $user->attachRole($socialRole);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }


}
