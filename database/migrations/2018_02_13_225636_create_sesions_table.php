<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSesionsTable extends Migration 
{
	public function up()
	{
		Schema::create('sesions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('sesion_equipo');
            $table->date('sesion_fecha');
            $table->time('sesion_hora');
            $table->integer('fk_usuario_id')->unsigned()->index();
            $table->foreign('fk_usuario_id')->references('id')->on('users');
          
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('sesions');
	}
}
