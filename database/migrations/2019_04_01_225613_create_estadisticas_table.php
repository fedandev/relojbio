<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadisticasTable extends Migration 
{
	public function up()
	{
		Schema::create('estadisticas', function(Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->string('total_horas_trabajadas');
            $table->string('total_horas_extras');
            $table->string('total_llegadas_tardes');
            $table->string('total_debe_trabajar');
            $table->timestamps();
            $table->index(['fecha_desde', 'fecha_hasta']);
        });
	}

	public function down()
	{
		Schema::drop('estadisticas');
	}
}
