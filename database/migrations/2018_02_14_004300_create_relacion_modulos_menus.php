<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelacionModulosMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('modulos_menus', function(Blueprint $table) {
            $table->integer('fk_modulo_id')->unsigned();
            $table->integer('fk_menu_id')->unsigned();
            $table->primary(['fk_modulo_id', 'fk_menu_id']);
            $table->foreign('fk_modulo_id')->references('id')->on('modulos');
            $table->foreign('fk_menu_id')->references('id')->on('menus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('modulos_menus');
    }
}
