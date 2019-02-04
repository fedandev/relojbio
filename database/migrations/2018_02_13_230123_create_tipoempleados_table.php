<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoEmpleadosTable extends Migration 
{
	public function up()
	{
		Schema::create('tipo_empleados', function(Blueprint $table) {
            $table->increments('id');
            $table->string('tipoempleado_nombre');
            $table->string('tipoempleado_descripcion');
            $table->integer('fk_tipohorario_id')->unsigned()->index();
            $table->foreign('fk_tipohorario_id')->references('id')->on('tipo_horarios');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('tipo_empleados');
	}
}
