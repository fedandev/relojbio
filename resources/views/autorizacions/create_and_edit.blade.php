@extends('layouts.app')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Autorización de horas extras/
                            @if($autorizacion->id)
                                Editar #{{$autorizacion->id}}
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
                        
                        @if($autorizacion->id)
                            <form action="{{ route('autorizacions.update', $autorizacion->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('autorizacions.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empleado</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_empleado_id" id="fk_empleado_id-field" value="{{ old('fk_empleado_id', $autorizacion->fk_empleado_id ) }}">
                                            @include('layouts.empleados')
                                        </select>
                                    </div>
                                </div>    
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Fecha Desde</label>
                                    <div class="col-sm-3"><input class="form-control" type="date" name="autorizacion_fechadesde" id="autorizacion_fechadesde-field" value="{{ old('autorizacion_fechadesde', $autorizacion->autorizacion_fechadesde ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Fecha Hasta</label>
                                    <div class="col-sm-3"><input class="form-control" type="date" name="autorizacion_fechahasta" id="autorizacion_fechahasta-field" value="{{ old('autorizacion_fechahasta', $autorizacion->autorizacion_fechahasta ) }}"></div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Antes de Hora</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="autorizacion_antesHorario" id="autorizacion_antesHorario-field" value="{{ old('autorizacion_antesHorario', $autorizacion->autorizacion_antesHorario ) }}">
                                            <option value="0">No</option>
                                            <option value="1">Si</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Despues de Hora</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="autorizacion_despuesHorario" id="autorizacion_despuesHorario-field" value="{{ old('autorizacion_despuesHorario', $autorizacion->autorizacion_despuesHorario ) }}">
                                            <option value="0">No</option>
                                            <option value="1">Si</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="autorizacion_descripcion" id="autorizacion_descripcion-field" value="{{ old('autorizacion_descripcion', $autorizacion->autorizacion_descripcion ) }}"></div>
                                </div>
                                
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('autorizacions.index') }}"> Cancelar</a>
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
            
            
            var tipo = $("#autorizacion_tipo-field").attr('value');
            if(tipo !=""){
                $('#autorizacion_tipo-field option[value="'+ tipo +'"]').prop("selected", true);
            }
            
            
            var empleado_id = $("#fk_empleado_id-field").attr('value');
            if(empleado_id>0){
                $('#fk_empleado_id-field option[value="'+ empleado_id +'"]').prop("selected", true);
            }
            
            $(".select2_demo_2").select2();
        });
    </script>
    
@endsection