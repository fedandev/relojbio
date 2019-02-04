<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeriadosTable extends Migration 
{
	public function up()
	{
		Schema::create('feriados', function(Blueprint $table) {
            $table->increments('id');
            $table->string('feriado_nombre');
            $table->string('feriado_coeficiente');
            $table->time('feriado_minimo');
            $table->date('feriado_fecha');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('feriados');
	}
}
