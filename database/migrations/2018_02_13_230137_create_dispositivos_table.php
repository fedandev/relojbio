<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispositivosTable extends Migration 
{
	public function up()
	{
		Schema::create('dispositivos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('dispositivo_nombre');
            $table->string('dispositivo_serial');
            $table->string('dispositivo_modelo');
            $table->string('dispositivo_ip');
            $table->string('dispositivo_puerto');
            $table->string('dispositivo_usuario');
            $table->string('dispositivo_password');
            $table->integer('fk_empresa_id')->unsigned()->index();
            $table->foreign('fk_empresa_id')->references('id')->on('empresas');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('dispositivos');
	}
}
