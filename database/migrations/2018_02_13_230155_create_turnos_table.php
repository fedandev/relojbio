<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnosTable extends Migration 
{
	public function up()
	{
		Schema::create('turnos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('turno_nombre');
            $table->string('turno_lunes');
            $table->string('turno_martes');
            $table->string('turno_miercoles');
            $table->string('turno_jueves');
            $table->string('turno_viernes');
            $table->string('turno_sabado');
            $table->string('turno_domingo');
            $table->integer('fk_horario_id')->unsigned()->index();
            $table->foreign('fk_horario_id')->references('id')->on('horarios');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('turnos');
	}
}
