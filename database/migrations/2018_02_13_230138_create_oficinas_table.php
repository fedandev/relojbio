<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOficinasTable extends Migration 
{
	public function up()
	{
		Schema::create('oficinas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('oficina_nombre');
            $table->string('oficina_descripcion')->nullable();
            $table->string('oficina_codigo')->nullable();
            $table->string('oficina_estado')->nullable();
            $table->integer('fk_sucursal_id')->unsigned()->index();
            $table->integer('fk_dispositivo_id')->unsigned()->index();
            $table->foreign('fk_sucursal_id')->references('id')->on('sucursals');
            $table->foreign('fk_dispositivo_id')->references('id')->on('dispositivos');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('oficinas');
	}
}
