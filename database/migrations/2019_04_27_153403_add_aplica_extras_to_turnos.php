<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAplicaExtrasToTurnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turnos', function (Blueprint $table) {
               
            $table->string('turno_lunes_he')->default('0')->nullable();
            $table->string('turno_martes_he')->default('0')->nullable();
            $table->string('turno_miercoles_he')->default('0')->nullable();
            $table->string('turno_jueves_he')->default('0')->nullable();
            $table->string('turno_viernes_he')->default('0')->nullable();
            $table->string('turno_sabado_he')->default('0')->nullable();
            $table->string('turno_domingo_he')->default('0')->nullable();
           
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
    }
}
