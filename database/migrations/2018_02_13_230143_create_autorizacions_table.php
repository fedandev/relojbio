<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacionsTable extends Migration 
{
	public function up()
	{
		Schema::create('autorizacions', function(Blueprint $table) {
            $table->increments('id');
            $table->date('autorizacion_fechadesde');
						$table->date('autorizacion_fechahasta');
            $table->string('autorizacion_antesHorario');
            $table->string('autorizacion_despuesHorario');
            $table->string('autorizacion_descripcion');
            $table->integer('fk_empleado_id')->unsigned();            
        		$table->foreign('fk_empleado_id')->references('id')->on('empleados');    
        		$table->index(['fk_empleado_id','autorizacion_fechadesde', 'autorizacion_fechahasta','autorizacion_antesHorario', 'autorizacion_despuesHorario'],'autorizacions02');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('autorizacions');
	}
}
