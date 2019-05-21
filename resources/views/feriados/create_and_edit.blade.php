@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Feriados /
                            @if($feriado->id)
                                Editar #{{$feriado->id}}
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
                        
                        @if($feriado->id)
                            <form action="{{ route('feriados.update', $feriado->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('feriados.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="feriado_nombre" id="feriado_nombre-field" value="{{ old('feriado_nombre', $feriado->feriado_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Coeficiente</label>
                                    <div class="col-sm-2">
                                        <select class="select2_demo_2 form-control" name="feriado_coeficiente" id="feriado_coeficiente-field" value="{{ old('feriado_coeficiente', $feriado->feriado_coeficiente ) }}">
                                            @include('layouts.coeficientes')
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Minimo Horas </label>
                                    <div class="col-sm-2">
                                        <select class="select2_demo_2 form-control" name="feriado_minimo" id="feriado_minimo-field" value="{{ old('feriado_minimo', $feriado->feriado_minimo ) }}">
                                            @include('layouts.horas')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Fecha</label>
                                    <div class="col-sm-2"><input class="form-control" type="date" name="feriado_fecha" id="feriado_fecha-field" value="{{ old('feriado_fecha', $feriado->feriado_fecha ) }}"></div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Laborable?</label>
                                    <div class="col-sm-3">
                                        <div class="i-checks">
                                            <label> 
                                                <input  type="hidden" name="feriado_laborable" id="feriado_laborable-field-1" value="0">
                                                <input type="checkbox" class="form-control" name="feriado_laborable" id="feriado_laborable-field" value="1"  {{ $feriado->feriado_laborable == '1' ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('feriados.index') }}"> Cancelar</a>
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
            $(".select2_demo_2").select2();
            
            var coeficiente_id = $("#feriado_coeficiente-field").attr('value');
            if(coeficiente_id>0){
                $('#feriado_coeficiente-field option[value="'+ coeficiente_id +'"]').prop("selected", true);
            }
            
            var horas_id = $("#feriado_minimo-field").attr('value');
            if(horas_id){
                $('#feriado_minimo-field option[value="'+ horas_id +'"]').prop("selected", true);
            }
            
        
        });
                  
    </script>
    
@endsection