<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenciasTable extends Migration 
{
	public function up()
	{
		Schema::create('licencias', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('licencia_anio');
            $table->integer('licencia_cantidad');
            $table->string('licencia_observaciones')->nullable();
            $table->integer('fk_tipolicencia_id')->unsigned()->index();
            $table->integer('fk_empleado_id')->unsigned()->index();
            $table->foreign('fk_empleado_id')->references('id')->on('empleados');
            $table->foreign('fk_tipolicencia_id')->references('id')->on('tipo_licencias');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('licencias');
	}
}
