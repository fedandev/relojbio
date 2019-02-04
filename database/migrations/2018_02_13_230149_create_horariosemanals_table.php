<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioSemanalsTable extends Migration 
{
	public function up()
	{
		Schema::create('horario_semanals', function(Blueprint $table) {
            $table->increments('id');
            $table->string('horariosemanal_nombre');
            $table->time('horariosemanal_horas');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('horario_semanals');
	}
}
