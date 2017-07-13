<?php

use Illuminate\Database\Seeder;
use \App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('themes')->delete();

        Theme::create([
            'name'        => 'default',
            'description' => null,
            'namespace'   => null
        ]);

        Theme::create([
            'name'        => 'new',
            'description' => 'New theme',
            'namespace'   => 'new'
        ]);

        Theme::create([
            'name'        => 'green',
            'description' => 'Green theme',
            'namespace'   => 'green'
        ]);

    }
}
