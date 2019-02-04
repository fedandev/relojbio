<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilsTable extends Migration 
{
	public function up()
	{
		Schema::create('perfils', function(Blueprint $table) {
            $table->increments('id');
            $table->string('perfil_nombre');
            $table->string('perfil_descripcion');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('perfils');
	}
}
