<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder{

    public function run(){
        DB::table('users')->delete();

        $adminRole = Role::whereName('admin')->first();
        $managerRole = Role::whereName('manager')->first();
        $customerRole = Role::whereName('customer')->first();
        $socialRole = Role::whereName('social')->first();
        $registeredRole = Role::whereName('registered')->first();
        $unconfirmedRole = Role::whereName('unconfirmed')->first();
        $userRole = Role::whereName('user')->first();

        $user = User::create(array(
            'name'     => 'Admin',
            'email'         => 'admin@test.com',
            'password'      => Hash::make('123')
        ));
        $user->attachRole($adminRole);

        $user = User::create(array(
            'name'     => 'Manager',
            'email'         => 'manager@test.com',
            'password'      => Hash::make('123')
        ));
        $user->attachRole($managerRole);

        $user = User::create(array(
            'name'     => 'Customer',
            'email'         => 'customer@test.com',
            'password'      => Hash::make('123')
        ));
        $user->attachRole($customerRole);

        $user = User::create(array(
            'name'     => 'Social',
            'email'         => 'social@test.com',
            'password'      => Hash::make('123')
        ));
        $user->attachRole($socialRole);

        $user = User::create(array(
            'name'     => 'reg',
            'email'         => 'reg@test.com',
            'password'      => Hash::make('123')
        ));
        $user->attachRole($registeredRole);

        $user = User::create(array(
            'name'     => 'Unconfirmed',
            'email'         => 'unconf@test.com',
            'password'      => Hash::make('123')
        ));
        $user->attachRole($unconfirmedRole);

    }
}
