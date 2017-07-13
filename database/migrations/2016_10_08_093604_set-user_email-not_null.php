<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetUserEmailNotNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->dropUnique('users_email_unique');
        });
        DB::statement('ALTER TABLE `users` MODIFY `email` VARCHAR(255);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `users` MODIFY `email` VARCHAR(255) UNSIGNED NOT NULL;');
        Schema::table('users', function($table)
        {
            $table->unique('email', 'users_email_unique');
        });
    }
}
