<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioRotativosTable extends Migration 
{
	public function up()
	{
		Schema::create('horario_rotativos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('horariorotativo_nombre');
            $table->string('horariorotativo_diacomienzo');
            $table->integer('horariorotativo_diastrabajo');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('horario_rotativos');
	}
}
