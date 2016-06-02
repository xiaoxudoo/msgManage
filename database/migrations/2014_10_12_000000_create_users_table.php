<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('u_id');
            $table->string('u_name');
            $table->string('u_password', 60);
            $table->integer('u_available_times')->default(5);
            $table->tinyInteger('u_login_state')->nullable();
            $table->integer('u_login_times')->nullable();
            // $table->rememberToken();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
