<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMediohorarioToHorarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('horarios', 'horario_haybrake_m')) {
            //
            Schema::table('horarios', function (Blueprint $table) {
                $table->string('horario_haybrake_m')->default('N')->nullable();
                $table->time('horario_entrada_m')->nullable();
                $table->time('horario_salida_m')->nullable();
                $table->time('horario_comienzobrake_m')->nullable();
                $table->time('horario_finbrake_m')->nullable();
            });
        }
        
        
       
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
