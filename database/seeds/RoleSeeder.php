<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        Role::create([
            'name'   => 'admin'
        ]);

        Role::create([
            'name'   => 'manager'
        ]);

        Role::create([
            'name'   => 'customer'
        ]);

        Role::create([
            'name'   => 'social'
        ]);

        Role::create([
            'name'   => 'registered'
        ]);

        Role::create([
            'name'   => 'unconfirmed'
        ]);

    }
}
