<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_friend')->unsigned();
            $table->integer('id_send')->unsigned();
            $table->boolean('isRead')->default(false);
            $table->text('text');
            $table->timestamps();

            $table->foreign('id_friend')
                ->references('id')
                ->on('friends')
                ->onDelete('cascade');

            $table->foreign('id_send')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
