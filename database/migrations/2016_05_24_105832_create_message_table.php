<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->engine = 'InnoDB';  //设置索引必须的
            $table->increments('m_id');
            $table->string('m_title',64)->unique();
            $table->integer('m_author');
            // $table->foreign('m_author')->references('id')->on('users');
            $table->date('m_create_date');
            $table->date('m_send_date');
            $table->timestamp('m_send_timestamp');
            $table->string('m_content',20480);
            $table->tinyInteger('msg_id');
            $table->foreign('msg_id')->references('msg_id')->on('message_second_group');
            $table->integer('m_received_amount')->default(0);
            $table->integer('m_sent_unreceived_amount')->default(0);
            $table->integer('m_total_amount')->default(0);
            $table->tinyInteger('m_is_display')->default(1);
            $table->timestamps();

            $table->index('m_title');
            $table->index('m_create_date');
            $table->index('m_send_date');
            $table->index('m_send_timestamp');
            $table->index('msg_id'); 
            // $table->index(array('m_title','m_create_date','m_send_date','m_send_timestamp','msg_id'));
            // 建联合索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('message');
    }
}
