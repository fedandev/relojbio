@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Dispositivo / Ver "{{$dispositivo->dispositivo_nombre}}"
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                   
                    
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group"><label class="col-lg-2 control-label">Nombre</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $dispositivo->dispositivo_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Serial</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $dispositivo->dispositivo_serial }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Modelo</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $dispositivo->dispositivo_modelo }} </p></div>
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                           
                            <div class="form-group"><label class="col-lg-2 control-label">IP</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $dispositivo->dispositivo_ip }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Puerto</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $dispositivo->dispositivo_puerto }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Usuario</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $dispositivo->dispositivo_usuario }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Empresa</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">
                                        @if($dispositivo->empresa)
                                            <a href="{{ route('empresas.show', $dispositivo->empresa->id) }}" target="_blank">{{$dispositivo->empresa->empresa_nombre}}</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('dispositivos.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('dispositivos.edit', $dispositivo->id) }}">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>


@endsection
