<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversacionsTable extends Migration 
{
	public function up()
	{
		Schema::create('conversacions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('conversacion_usuario_envia')->unsigned()->index();
            $table->integer('conversacion_usuario_recibe')->unsigned()->index();
            $table->datetime('conversacion_fecha');
            $table->foreign('conversacion_usuario_envia')->references('id')->on('users');
            $table->foreign('conversacion_usuario_recibe')->references('id')->on('users');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('conversacions');
	}
}
