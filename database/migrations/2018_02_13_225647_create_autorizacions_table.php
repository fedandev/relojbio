<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacionsTable extends Migration 
{
	public function up()
	{
		Schema::create('autorizacions', function(Blueprint $table) {
            $table->increments('id');
            $table->date('autorizacion_dia');
            $table->string('autorizacion_tipo');
            $table->string('autorizacion_descripcion');
            $table->string('autorizacion_autorizado');
            $table->integer('fk_empleado_id')->unsigned();
            $table->integer('fk_user_id')->unsigned()->index();
        	$table->foreign('fk_empleado_id')->references('id')->on('empleados');
        	$table->foreign('fk_user_id')->references('id')->on('users');
        	$table->index(['fk_empleado_id','autorizacion_dia', 'autorizacion_tipo']);
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('autorizacions');
	}
}
