<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibreDetallesTable extends Migration 
{
	public function up()
	{
		Schema::create('libre_detalles', function(Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->string('comentarios');
            $table->integer('fk_tipo_libre_id')->unsigned()->index();
            $table->foreign('fk_tipo_libre_id')->references('id')->on('tipo_libres');
            $table->integer('fk_empleado_id')->unsigned()->index();
            $table->foreign('fk_empleado_id')->references('id')->on('empleados');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('libre_detalles');
	}
}
