<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosTable extends Migration 
{
	public function up()
	{
		Schema::create('modulos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('modulo_nombre');
            $table->string('modulo_descripcion');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('modulos');
	}
}
