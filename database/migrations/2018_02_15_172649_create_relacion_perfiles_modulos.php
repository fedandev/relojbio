<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelacionPerfilesModulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('perfiles_modulos', function(Blueprint $table) {
            $table->integer('fk_perfil_id')->unsigned();
            $table->integer('fk_modulo_id')->unsigned();
            $table->primary(['fk_perfil_id', 'fk_modulo_id']);
            $table->foreign('fk_perfil_id')->references('id')->on('perfils');
            $table->foreign('fk_modulo_id')->references('id')->on('modulos');
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
        //
        Schema::drop('perfiles_modulos');
    }
}
