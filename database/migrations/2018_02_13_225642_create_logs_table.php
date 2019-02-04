<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration 
{
	public function up()
	{
		Schema::create('logs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('log_fecha');
            $table->string('log_accion');
            $table->string('log_tabla');
            $table->string('log_parametro');
            $table->string('log_otros');
            $table->integer('fk_usuario_id')->unsigned()->index();
            $table->foreign('fk_usuario_id')->references('id')->on('users');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('logs');
	}
}
