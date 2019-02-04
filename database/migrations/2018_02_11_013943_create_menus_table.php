<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration 
{
	public function up()
	{
		Schema::create('menus', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_padre_id');
            $table->string('menu_descripcion');
            $table->integer('menu_posicion')->default(0)->index();
            $table->integer('menu_habilitado');
            $table->string('menu_url')->nullable();
            $table->string('menu_icono')->nullable();
            $table->string('menu_formulario')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('menus');
	}
}
