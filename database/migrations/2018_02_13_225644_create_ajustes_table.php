<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjustesTable extends Migration 
{
	public function up()
	{
		Schema::create('ajustes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('ajuste_nombre');
            $table->string('ajuste_valor')->nullable();
            $table->string('ajuste_descripcion')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('ajustes');
	}
}
