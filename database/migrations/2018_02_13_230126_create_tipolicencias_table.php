<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoLicenciasTable extends Migration 
{
	public function up()
	{
		Schema::create('tipo_licencias', function(Blueprint $table) {
            $table->increments('id');
            $table->string('tipolicencia_nombre');
            $table->string('tipolicencia_descripcion');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('tipo_licencias');
	}
}
