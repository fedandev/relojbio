<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration 
{
	public function up()
	{
		Schema::create('empresas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('empresa_nombre');
            $table->string('empresa_telefono')->nullable();
            $table->string('empresa_estado')->nullable();
            $table->date('empresa_ingreso')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('empresas');
	}
}
