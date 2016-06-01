<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageFirstGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_first_group', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->primary('mfg_id');
            $table->tinyInteger('mfg_id')->unique();
            $table->string('mfg_name', 32);
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
        Schema::drop('message_first_group');
    }
}
