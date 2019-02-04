<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelacionPerfilesPermisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfiles_permisos', function(Blueprint $table) {
            $table->integer('perfil_id')->unsigned();
            $table->integer('permiso_id')->unsigned();
            $table->string('perfil_permiso_habilita')->default('S');
            $table->primary(['perfil_id', 'permiso_id']);
            $table->foreign('perfil_id')->references('id')->on('perfils');
            $table->foreign('permiso_id')->references('id')->on('permisos');
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
        Schema::drop('perfiles_permisos');
    }
}


///Se ejecuto el siguiente comando:  php artisan make:migration create_relacion_perfiles_permisos