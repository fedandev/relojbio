<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalsTable extends Migration 
{
	public function up()
	{
		Schema::create('sucursals', function(Blueprint $table) {
            $table->increments('id');
            $table->string('sucursal_nombre');
            $table->string('sucursal_descripcion');
            $table->integer('fk_empresa_id')->unsigned()->index();
            $table->foreign('fk_empresa_id')->references('id')->on('empresas');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('sucursals');
	}
}
