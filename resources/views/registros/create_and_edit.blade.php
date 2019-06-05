@extends('layouts.app')

@section('content')

    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Registro /
                            @if($registro->id)
                                Editar #{{$registro->id}}
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
                        @if($registro->id)
                            <form action="{{ route('registros.update', $registro->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('registros.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Hora</label>
                                  
                                    <div class="col-sm-3">
                                        <input class="form-control" type="text" name="registro_hora" id="registro_hora-field" value="{{ old('registro_hora', $registro->registro_hora ) }}">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Fecha</label>
                                    <div class="col-sm-3"><input class="form-control" type="date" name="registro_fecha" id="registro_fecha-field" value="{{ old('registro_fecha', $registro->registro_fecha ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Marca</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control m-b" name="registro_tipo" id="registro_tipo-field" value="{{ old('registro_tipo', $registro->registro_tipo ) }}">
                                            <option value="I"> Entrada</option>
                                            <option value="O"> Salida</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="registro_tipomarca" value="{{ old('registro_tipomarca', $registro->registro_tipomarca ) }}">
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Dispositivo</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_dispositivo_id" id="fk_dispositivo_id-field" value="{{ old('fk_dispositivo_id', $registro->fk_dispositivo_id ) }}">
                                            @include('layouts.dispositivos')
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empleado</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_empleado_cedula" id="fk_empleado_cedula-field" value="{{ old('fk_empleado_cedula', $registro->fk_empleado_cedula ) }}">
                                            @include('layouts.empleadosXcedula');
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Comentarios</label>
                                    <div class="col-sm-10"><textarea rows="4" cols="50" name="registro_comentarios" id="registro_comentarios-field" value="{{ old('registro_comentarios', $registro->registro_comentarios ) }}"></textarea></div>
                                </div>
                                
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('registros.index') }}"> Cancelar</a>
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

    <script src="{{ asset('js/plugins/jquery.mask.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
                
            $('#registro_hora-field').mask('00:00:00');
            
            var ci = $("#fk_empleado_cedula-field").attr('value');
            if(ci>0){
                $('#fk_empleado_cedula-field option[value="'+ ci +'"]').prop("selected", true);
            }
            
            var datetime = $("#registro_hora-field").attr('value');
            var format = datetime.substr(-8);
            $("#registro_hora-field").val(format);
            var dispositivo_id = $("#fk_dispositivo_id-field").attr('value');
            
            if(dispositivo_id>0){
                $('#fk_dispositivo_id-field option[value="'+ dispositivo_id +'"]').prop("selected", true);
            }
            var registro_tipo = $("#registro_tipo-field").attr('value');
            $('#registro_tipo-field option[value="'+ registro_tipo +'"]').prop("selected", true);
            $(".select2_demo_2").select2();
            
            
        });
    </script>
@endsection


