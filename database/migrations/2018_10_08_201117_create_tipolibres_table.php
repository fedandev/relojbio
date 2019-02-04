<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoLibresTable extends Migration 
{
	public function up()
	{
		Schema::create('tipo_libres', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('tipo_libres');
	}
}
