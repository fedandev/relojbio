<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration 
{
	public function up()
	{
		Schema::create('empleados', function(Blueprint $table) {
            $table->increments('id');
            $table->string('empleado_cedula')->unique();
            $table->string('empleado_codigo')->nullable();
            $table->string('empleado_nombre');
            $table->string('empleado_apellido');
            $table->string('empleado_correo')->nullable();
            $table->string('empleado_telefono')->nullable();
            $table->date('empleado_fingreso')->nullable();
            //$table->time('empleado_diferenciatiempo')->nullable();
            $table->string('empleado_estado')->nullable();
            $table->integer('fk_tipoempleado_id')->unsigned()->index();
            $table->integer('fk_oficina_id')->unsigned()->index();
            $table->foreign('fk_tipoempleado_id')->references('id')->on('tipo_empleados');
            $table->foreign('fk_oficina_id')->references('id')->on('oficinas');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('empleados');
	}
}
