<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrosTable extends Migration 
{
	public function up()
	{
		Schema::create('registros', function(Blueprint $table) {
            $table->increments('id');
            $table->datetime('registro_hora');
            $table->date('registro_fecha')->index();
            $table->string('registro_tipomarca')->nullable();
            $table->string('registro_comentarios')->nullable();
            $table->string('registro_registrado')->nullable();
            $table->string('registro_tipo')->nullable();
            $table->string('fk_empleado_cedula')->index();
            $table->integer('fk_dispositivo_id')->unsigned()->index();
            $table->foreign('fk_empleado_cedula')->references('empleado_cedula')->on('empleados');
            $table->foreign('fk_dispositivo_id')->references('id')->on('dispositivos');
            $table->index(['registro_fecha', 'fk_empleado_cedula']);
            $table->index(['registro_hora', 'fk_empleado_cedula', 'registro_tipo' ]);
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('registros');
	}
}
