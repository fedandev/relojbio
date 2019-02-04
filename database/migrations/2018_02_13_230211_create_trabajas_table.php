<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajasTable extends Migration 
{
	public function up()
	{
		Schema::create('trabajas', function(Blueprint $table) {
            $table->increments('id');
            $table->date('trabaja_fechainicio');
            $table->date('trabaja_fechafin');
            $table->integer('fk_horariorotativo_id')->unsigned()->index()->nullable();
            $table->integer('fk_turno_id')->unsigned()->index()->nullable();
            $table->integer('fk_horariosemanal_id')->unsigned()->index()->nullable();
            //$table->integer('fk_empresa_id')->unsigned()->index();
            $table->foreign('fk_horariorotativo_id')->references('id')->on('horario_rotativos');
            $table->foreign('fk_turno_id')->references('id')->on('turnos');
            $table->foreign('fk_horariosemanal_id')->references('id')->on('horario_semanals');
            //$table->foreign('fk_empresa_id')->references('id')->on('empresas');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('trabajas');
	}
}
