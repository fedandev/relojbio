<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenciaDetallesTable extends Migration 
{
	public function up()
	{
		Schema::create('licencia_detalles', function(Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->string('aplica_sabado')->default('N');
            $table->string('aplica_domingo')->default('N');
            $table->string('aplica_libre')->default('N');
            $table->string('comentarios')->nullable();
            $table->integer('fk_licencia_id')->unsigned()->index();
            $table->foreign('fk_licencia_id')->references('id')->on('licencias');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('licencia_detalles');
	}
}
