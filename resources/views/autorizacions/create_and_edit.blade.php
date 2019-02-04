@extends('layouts.app')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Autorización /
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
                                <input type="hidden" name="fk_user_id" id="fk_user_id-field" value="{{ auth()->user()->id }}">    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empleado</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_empleado_id" id="fk_empleado_id-field" value="{{ old('fk_empleado_id', $autorizacion->fk_empleado_id ) }}">
                                            @include('layouts.empleados')
                                        </select>
                                    </div>
                                </div>    
                                
                               
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Día</label>
                                    <div class="col-sm-3"><input class="form-control" type="date" name="autorizacion_dia" id="autorizacion_dia-field" value="{{ old('autorizacion_dia', $autorizacion->autorizacion_dia ) }}"></div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="autorizacion_tipo" id="autorizacion_tipo-field" value="{{ old('autorizacion_tipo', $autorizacion->autorizacion_tipo ) }}">
                                            <option value="">Seleccionar tipo...</option>
                                            <option value="HORA_EXTRA">Horas extras</option>
                                            <option value="FALTA">Falta</option>
                                            <option value="L_TARDE">Llegada tarde</option>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="autorizacion_descripcion" id="autorizacion_descripcion-field" value="{{ old('autorizacion_descripcion', $autorizacion->autorizacion_descripcion ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Autorizado</label>

                                    <div class="col-sm-10">
                                        <div class="i-checks">
                                            <label> 
                                                <input type="radio" name="autorizacion_autorizado" id="autorizacion_autorizado-field" value="SI" {{ $autorizacion->autorizacion_autorizado == 'SI' ? 'checked' : '' }}>  Si 
                                            </label>
                                        </div>
                                        <div class="i-checks">
                                            <label> 
                                                <input type="radio" name="autorizacion_autorizado" id="autorizacion_autorizado-field" value="NO" {{ $autorizacion->autorizacion_autorizado == 'NO' ? 'checked' : '' }}>   No
                                            </label>
                                        </div>
                                    </div>
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