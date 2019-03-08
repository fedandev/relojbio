@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Horarios /
                            @if($horario->id)
                                Editar #{{$horario->id}}
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
                        
                        @if($horario->id)
                            <form action="{{ route('horarios.update', $horario->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('horarios.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                               
                                <div class="row">
                                    <div class="col-sm-6 b-r"><h3 class="bg-muted p-xs b-r-sm">Horario Normal</h3>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nombre</label>
                                            <div class="col-sm-6"><input class="form-control" type="text" name="horario_nombre" id="horario_nombre-field" value="{{ old('horario_nombre', $horario->horario_nombre ) }}"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Hora Entrada</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_entrada" id="horario_entrada-field" value="{{ old('horario_entrada', $horario->horario_entrada ) }}"></div>
                                        
                                            <label class="col-sm-3 control-label">Hora Salida</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_salida" id="horario_salida-field" value="{{ old('horario_salida', $horario->horario_salida ) }}"></div>
                                        
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Aplica brake?</label>
                                            <div class="col-sm-3">
                                                <div class="i-checks">
                                                    <label> 
                                                        <input  type="hidden" name="horario_haybrake" id="horario_haybrake-field-1" value="N">
                                                        <input type="checkbox" class="form-control" name="horario_haybrake" id="horario_haybrake-field" value="S"  {{ $horario->horario_haybrake == 'S' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group" id="datos_brake">
                                            <label class="col-sm-3 control-label">Inicio Brake</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_comienzobrake" id="horario_comienzobrake-field" value="{{ old('horario_comienzobrake', $horario->horario_comienzobrake ) }}"></div>
                                        
                                            <label class="col-sm-3 control-label">Fin Brake</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_finbrake" id="horario_finbrake-field" value="{{ old('horario_finbrake', $horario->horario_finbrake ) }}"></div>
                                        
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tolerancia Llegada Tarde</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_tiempotarde" id="horario_tiempotarde-field" value="{{ old('horario_tiempotarde', $horario->horario_tiempotarde ) }}"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tolerancia Salida Antes</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_salidaantes" id="horario_salidaantes-field" value="{{ old('horario_salidaantes', $horario->horario_salidaantes ) }}"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6"><h3 class="bg-muted p-xs b-r-sm">Medio Horario</h3>
                                        
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Hora Entrada</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_entrada_m" id="horario_entrada_m-field" value="{{ old('horario_entrada_m', $horario->horario_entrada_m ) }}"></div>
                                        
                                            <label class="col-sm-3 control-label">Hora Salida</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_salida_m" id="horario_salida_m-field" value="{{ old('horario_salida_m', $horario->horario_salida_m ) }}"></div>
                                        
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Aplica brake?</label>
                                            <div class="col-sm-3">
                                                <div class="i-checks">
                                                    <label> 
                                                        <input  type="hidden" name="horario_haybrake_m" id="horario_haybrake_m-field-1" value="N">
                                                        <input type="checkbox" class="form-control" name="horario_haybrake_m" id="horario_haybrake_m-field" value="S"  {{ $horario->horario_haybrake_m == 'S' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group" id="datos_brake_m">
                                            <label class="col-sm-3 control-label">Inicio Brake</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_comienzobrake_m" id="horario_comienzobrake_m-field" value="{{ old('horario_comienzobrake_m', $horario->horario_comienzobrake_m ) }}"></div>
                                        
                                            <label class="col-sm-3 control-label">Fin Brake</label>
                                            <div class="col-sm-3"><input class="form-control" type="time" name="horario_finbrake_m" id="horario_finbrake_m-field" value="{{ old('horario_finbrake_m', $horario->horario_finbrake_m ) }}"></div>
                                        
                                        </div>
                                    </div>
                                </div>    
                                
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-4">
                                        <a class="btn btn-white" href="{{ route('horarios.index') }}"> Cancelar</a>
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
            
            if($("#horario_haybrake-field").is(":checked")){
                $('#datos_brake').show();
                
            }else{
                $('#datos_brake').hide();
                $('#horario_comienzobrake-field').val("00:00");
                $('#horario_finbrake-field').val("00:00");
            }
            
            
            $('#horario_haybrake-field').on('ifChecked', function () { 
                $('#datos_brake').show();
                $('#horario_comienzobrake-field').val("00:00");
                $('#horario_finbrake-field').val("00:00");
                
                
            });

            // For onUncheck callback
            $('#horario_haybrake-field').on('ifUnchecked', function () { 
                $('#datos_brake').hide();
                $('#horario_comienzobrake-field').val("00:00");
                $('#horario_finbrake-field').val("00:00");
            
            });
            
            
            
            if($("#horario_haybrake_m-field").is(":checked")){
                $('#datos_brake_m').show();
                
            }else{
                $('#datos_brake_m').hide();
                $('#horario_comienzobrake_m-field').val("00:00");
                $('#horario_finbrake_m-field').val("00:00");
            }
            
            
            $('#horario_haybrake_m-field').on('ifChecked', function () { 
                $('#datos_brake_m').show();
                $('#horario_comienzobrake_m-field').val("00:00");
                $('#horario_finbrake_m-field').val("00:00");
                
                
            });

            // For onUncheck callback
            $('#horario_haybrake_m-field').on('ifUnchecked', function () { 
                $('#datos_brake_m').hide();
                $('#horario_comienzobrake_m-field').val("00:00");
                $('#horario_finbrake-field_m').val("00:00");
            
            });
            
        });    
       
        
       
    </script>
    
@endsection