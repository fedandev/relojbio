<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMediohorarioToTurnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turnos', function (Blueprint $table) {
           
            $table->string('turno_lunes_mh')->default('0')->nullable();
            $table->string('turno_martes_mh')->default('0')->nullable();
            $table->string('turno_miercoles_mh')->default('0')->nullable();
            $table->string('turno_jueves_mh')->default('0')->nullable();
            $table->string('turno_viernes_mh')->default('0')->nullable();
            $table->string('turno_sabado_mh')->default('0')->nullable();
            $table->string('turno_domingo_mh')->default('0')->nullable();
           
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
