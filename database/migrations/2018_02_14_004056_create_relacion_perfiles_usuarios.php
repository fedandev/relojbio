<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelacionPerfilesUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfiles_usuarios', function(Blueprint $table) {
            $table->integer('fk_user_id')->unsigned();
            $table->integer('fk_perfil_id')->unsigned();
            $table->primary(['fk_user_id', 'fk_perfil_id']);
            $table->foreign('fk_user_id')->references('id')->on('users');
            $table->foreign('fk_perfil_id')->references('id')->on('perfils');
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
        Schema::drop('perfiles_usuarios');
    }
}
