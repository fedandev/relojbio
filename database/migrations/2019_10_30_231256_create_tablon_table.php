<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tablon_fk_empleado_cedula')->index();
            $table->date('tablon_fecha')->index();
            $table->time('tablon_h_entrada');
            $table->time('tablon_h_ini_brake');
            $table->time('tablon_h_fin_brake');
            $table->time('tablon_h_salida');            
            $table->time('tablon_h_debe_trabajar');    
            $table->time('tablon_h_trabajadas');
            $table->time('tablon_h_extras');
            $table->time('tablon_h_llegadas_tardes');
            $table->string('tablon_es_dia_licencia',1);
            $table->string('tablon_es_dia_libre',1);
            $table->string('tablon_es_dia_feriado',1);
            $table->string('tablon_es_dia_facturable',1);
            $table->string('tablon_es_medio_horario',1);
            $table->string('tablon_es_nocturno_horario',1);
            $table->string('tablon_h_extras_auth',1);
            $table->string('tablon_debe_trabajar',1);
            $table->foreign('tablon_fk_empleado_cedula')->references('empleado_cedula')->on('empleados');
            $table->index(['tablon_fecha', 'tablon_fk_empleado_cedula']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tablon');
    }
}
