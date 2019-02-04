<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajesTable extends Migration 
{
	public function up()
	{
		Schema::create('mensajes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('mensaje_mensaje');
            $table->datetime('mensaje_fecha');
            $table->string('mensaje_leido');
            $table->integer('mensaje_usuario_envia')->unsigned()->index();
            $table->integer('fk_conversacion_id')->unsigned()->index();;
            $table->foreign('fk_conversacion_id')->references('id')->on('conversacions');
            $table->foreign('mensaje_usuario_envia')->references('id')->on('users');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('mensajes');
	}
}
