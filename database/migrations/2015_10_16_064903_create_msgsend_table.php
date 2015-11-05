<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgsendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msgsend', function (Blueprint $table) {
            $table->integer('id');
            $table->string('sendby',10);
            $table->primary('id');
            $table->foreign('id')->references('id')->on('messages');
            $table->foreign('sendby')->references('id')->on('users');
            $table->integer('isdelete');
            $table->integer('isdraft');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('msgsend');
    }
}
