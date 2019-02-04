@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Dispositivo /
                            @if($dispositivo->id)
                                Editar #{{$dispositivo->id}}
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
                        
                        @if($dispositivo->id)
                            <form action="{{ route('dispositivos.update', $dispositivo->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('dispositivos.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="dispositivo_nombre" id="dispositivo_nombre-field" value="{{ old('dispositivo_nombre', $dispositivo->dispositivo_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Serial</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="dispositivo_serial" id="dispositivo_serial-field" value="{{ old('dispositivo_serial', $dispositivo->dispositivo_serial ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Modelo</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="dispositivo_modelo" id="dispositivo_modelo-field" value="{{ old('dispositivo_modelo', $dispositivo->dispositivo_modelo ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">IP</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" data-mask="999.999.999.9999" placeholder="" name="dispositivo_ip" id="dispositivo_ip-field" value="{{ old('dispositivo_ip', $dispositivo->dispositivo_ip ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Puerto</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="dispositivo_puerto" id="dispositivo_puerto-field" value="{{ old('dispositivo_puerto', $dispositivo->dispositivo_puerto ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Usuario</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="dispositivo_usuario" id="dispositivo_usuario-field" value="{{ old('dispositivo_usuario', $dispositivo->dispositivo_usuario ) }}"></div>
                                </div>
                                
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-6"><input class="form-control" type="password" name="dispositivo_password" id="dispositivo_password-field" value="{{ old('dispositivo_password', $dispositivo->dispositivo_password ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empresa</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_empresa_id" id="fk_empresa_id-field" value="{{ old('fk_empresa_id', $dispositivo->fk_empresa_id ) }}">
                                            @include('layouts.empresas')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('dispositivos.index') }}"> Cancelar</a>
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
            
            var empresa_id = $("#fk_empresa_id-field").attr('value');
            if(empresa_id>0){
                $('#fk_empresa_id-field option[value="'+ empresa_id +'"]').prop("selected", true);
            }
        });
    </script>
    
@endsection