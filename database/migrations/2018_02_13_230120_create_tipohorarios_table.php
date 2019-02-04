<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoHorariosTable extends Migration 
{
	public function up()
	{
		Schema::create('tipo_horarios', function(Blueprint $table) {
            $table->increments('id');
            $table->string('tipohorario_nombre');
            $table->string('tipohorario_descripcion');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('tipo_horarios');
	}
}
