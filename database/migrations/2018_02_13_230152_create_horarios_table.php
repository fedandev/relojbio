<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosTable extends Migration 
{
	public function up()
	{
		Schema::create('horarios', function(Blueprint $table) {
            $table->increments('id');
            $table->string('horario_nombre');
            $table->time('horario_entrada');
            $table->time('horario_salida');
            $table->time('horario_comienzobrake');
            $table->time('horario_finbrake');
            $table->time('horario_tiempotarde');
            $table->time('horario_salidaantes');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('horarios');
	}
}
