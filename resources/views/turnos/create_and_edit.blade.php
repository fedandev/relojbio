@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Turno /
                            @if($turno->id)
                                Editar #{{$turno->turno_nombre}}
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
                        @if($turno->id)
                            <form action="{{ route('turnos.update', $turno->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('turnos.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="text" name="turno_nombre" id="turno_nombre-field" value="{{ old('turno_nombre', $turno->turno_nombre ) }}">
                                           
                                    </div>
                                
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Lunes</label>
                                    <div class="col-sm-1">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_lunes" id="turno_lunes-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_lunes" id="turno_lunes-field" value="1" {{ $turno->turno_lunes == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <label class="col-sm-2 control-label">Aplica Medio Horario?</label>
                                    <div class="col-sm-3">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_lunes_mh" id="turno_lunes_mh-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_lunes_mh" id="turno_lunes_mh-field" value="1" {{ $turno->turno_lunes_mh == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Martes</label>
                                    <div class="col-sm-1">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_martes" id="turno_martes-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_martes" id="turno_martes-field" value="1" {{ $turno->turno_martes == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <label class="col-sm-2 control-label">Aplica Medio Horario?</label>
                                    <div class="col-sm-3">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_martes_mh" id="turno_martes_mh-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_martes_mh" id="turno_martes_mh-field" value="1" {{ $turno->turno_martes_mh == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Miercoles</label>
                                    <div class="col-sm-1">
                                        <div class="i-checks">
                                            <label>
                                                <input  type="hidden" name="turno_miercoles" id="turno_miercoles-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_miercoles" id="turno_miercoles-field" value="1" {{ $turno->turno_miercoles == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <label class="col-sm-2 control-label">Aplica Medio Horario?</label>
                                    <div class="col-sm-3">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_miercoles_mh" id="turno_miercoles_mh-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_miercoles_mh" id="turno_miercoles_mh-field" value="1" {{ $turno->turno_miercoles_mh == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Jueves</label>
                                    <div class="col-sm-1">
                                        <div class="i-checks">
                                            <label>
                                                <input  type="hidden" name="turno_jueves" id="turno_jueves-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_jueves" id="turno_jueves-field" value="1" {{ $turno->turno_jueves == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>      
                                    
                                    
                                    <label class="col-sm-2 control-label">Aplica Medio Horario?</label>
                                    <div class="col-sm-3">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_jueves_mh" id="turno_jueves_mh-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_jueves_mh" id="turno_jueves_mh-field" value="1" {{ $turno->turno_jueves_mh == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Viernes</label>
                                    <div class="col-sm-1">
                                        <div class="i-checks">
                                            <label>
                                                <input  type="hidden" name="turno_viernes" id="turno_viernes-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_viernes" id="turno_viernes-field" value="1" {{ $turno->turno_viernes == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <label class="col-sm-2 control-label">Aplica Medio Horario?</label>
                                    <div class="col-sm-3">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_viernes_mh" id="turno_viernes_mh-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_viernes_mh" id="turno_viernes_mh-field" value="1" {{ $turno->turno_viernes_mh == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Sabado</label>
                                    <div class="col-sm-1">
                                        <div class="i-checks">
                                            <label>
                                                <input  type="hidden" name="turno_sabado" id="turno_sabado-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_sabado" id="turno_sabado-field" value="1" {{ $turno->turno_sabado == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    
                                    <label class="col-sm-2 control-label">Aplica Medio Horario?</label>
                                    <div class="col-sm-3">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_sabado_mh" id="turno_sabado_mh-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_sabado_mh" id="turno_sabado_mh-field" value="1" {{ $turno->turno_sabado_mh == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Domingo</label>
                                    <div class="col-sm-1">
                                        <div class="i-checks">
                                            <label>
                                                <input  type="hidden" name="turno_domingo" id="turno_domingo-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_domingo" id="turno_domingo-field" value="1" {{ $turno->turno_domingo == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <label class="col-sm-2 control-label">Aplica Medio Horario?</label>
                                    <div class="col-sm-3">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="turno_domingo_mh" id="turno_domingo_mh-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="turno_domingo_mh" id="turno_domingo_mh-field" value="1" {{ $turno->turno_domingo_mh == 1 ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Horario</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_horario_id" id="fk_horario_id-field" value="{{ old('fk_horario_id', $turno->fk_horario_id ) }}">
                                            @include('layouts.horarios')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                 
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('turnos.index') }}"> Cancelar</a>
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
            var horario_id = $("#fk_horario_id-field").attr('value');
            if(horario_id>0){
                $('#fk_horario_id-field option[value="'+ horario_id +'"]').prop("selected", true);
            }
            
            
            $(".select2_demo_2").select2();
        });
                  
    </script>
    
@endsection