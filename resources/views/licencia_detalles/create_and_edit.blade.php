@extends('layouts.app')

@section('content')
<?php
use Carbon\Carbon;
?>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Licencia /
                            @if($licencia_detalle->id)
                                Editar #{{$licencia_detalle->id}}
                            @else
                                Nuevo
                            @endif
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">
                        @include('common.error')
                        
                        @if($licencia_detalle->id)
                            <form action="{{ route('licencia_detalles.update', $licencia_detalle->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('licencia_detalles.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empleado</label>
                                    <div class="col-sm-5">
                                        <select class="select2_demo_2 form-control" name="fk_empleado_id" id="fk_empleado_id-field" value="{{ old('fk_empleado_id', $licencia_detalle->fk_empleado_id ) }}">
                                            @include('layouts.empleados')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo Licencia</label>
                                    <div class="col-sm-5" id="tipolicencia">
                                        <select class="select2_demo_2 form-control" name="fk_licencia_id" id="fk_licencia_id-field" value="{{ old('fk_licencia_id', $licencia_detalle->licencia['licencia_anio'] ) }}">
                                        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Días restantes</label>
                                    <div class="col-sm-5">
                                        <input class="form-control" type="text" name="licencia_cantidad" id="licencia_cantidad-field" value="{{ old('licencia_cantidad', 
                                            $inicio = Carbon::parse($licencia_detalle->fecha_desde)->diffInDays(Carbon::parse($licencia_detalle->fecha_hasta))) }}" 
                                            readonly="readonly">
                                    </div>
                                </div>
                                
                                <div class="form-group" id="data_1">
                                    <label class="col-sm-2 control-label">Desde</label>
                                    <div class="input-group date col-sm-3">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control" type="text" name="fecha_desde" id="fecha_desde-field" value="{{ old('fecha_desde', $licencia_detalle->fecha_desde ) }}">
                                    </div>
                                </div>
                                
                                <div class="form-group" id="data_1">
                                    <label class="col-sm-2 control-label">Hasta</label>
                                    <div class="input-group date col-sm-3">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control" type="text" name="fecha_hasta" id="fecha_hasta-field" value="{{ old('fecha_hasta', $licencia_detalle->fecha_hasta ) }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Aplica</label>
                                    <div class="col-sm-5">
                                        
                                        <label class="checkbox-inline">
                                        <input type="checkbox" name="aplica_sabado" id="aplica_sabado-field" value="S" {{ $licencia_detalle->aplica_sabado == 'S' ? 'checked' : '' }} > Sabado </label> <label class="checkbox-inline">
                                        <input type="checkbox" name="aplica_domingo" id="aplica_domingo-field" value="S" {{ $licencia_detalle->aplica_domingo == 'S' ? 'checked' : '' }}> Domingo </label> <label class="checkbox-inline">
                                        <input type="checkbox" name="aplica_libre" id="aplica_libre-field" value="S" {{ $licencia_detalle->aplica_libre == 'S' ? 'checked' : '' }}> Día Libre</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Observaciones</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control" name="comentarios" id="comentarios-field" rows="3" placeholder="Observaciones..." value="{{ old('comentarios', $licencia_detalle->comentarios ) }}"></textarea>
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('licencia_detalles.index') }}"> Cancelar</a>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </div>
                                </div>
                            </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
            
            $("#licencia_cantidad-field").val(0);
            
            $("#fk_empleado_id-field").change(event => {
                $("#licencia_cantidad-field").val(0);
                $.get(`../../tipolicencia/${event.target.value}`, function(res, sta){
                    $('#fk_licencia_id-field').empty();
                    if(res.length>=0){
    		            $("#fk_licencia_id-field").append('<option> Seleccione un tipo de licencia.</option>');
                        res.forEach(element => {
                            $('#fk_licencia_id-field').append(`<option value=${element.id}> ${element.caracteristica_detalle_nombre} </option>`);
                        });
		            }
                    $(".select2_demo_2").select2();
                });
            });
            
            $(".select2_demo_2").select2();
            
            $("#fk_licencia_id-field").change(function(event){
                $.get("../licencia/"+event.target.value+"",function(response,licencia){
                    if($.isEmptyObject(response)){
                        $("#licencia_cantidad-field").val("0");
                    }else{
                        $("#licencia_cantidad-field").val(response[0].licencia_cantidad);
                    }
                });
            });
        });
    </script>
@endsection