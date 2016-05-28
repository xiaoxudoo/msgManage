<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageSecondGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_second_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyInteger('msg_id');
            $table->primary('msg_id');
            $table->index('msg_id');
            $table->tinyInteger('mfg_id');
            $table->index('mfg_id');
            $table->foreign('mfg_id')->references('mfg_id')->on('message_first_groups');
            $table->string('msg_name', 32)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('message_second_groups');
    }
}
