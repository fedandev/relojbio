<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration 
{
	public function up()
	{
		Schema::create('permisos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('permiso_nombre');
            $table->integer('permiso_habilita');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('permisos');
	}
}
