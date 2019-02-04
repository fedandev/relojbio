@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Oficina / Ver "{{$oficina->oficina_nombre}}"
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                   
                    
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nombre</label>
                                <div class="col-lg-6"><p class="form-control-static">{{  $oficina->oficina_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Descripcion</label>
                                <div class="col-lg-6"><p class="form-control-static">{{  $oficina->oficina_descripcion }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Código</label>
                                <div class="col-lg-6"><p class="form-control-static">{{  $oficina->oficina_codigo }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                           
                            <div class="form-group"><label class="col-lg-2 control-label">Estado</label>
                                <div class="col-lg-3">
                                        <p class="form-control-static">
                                            @if ($oficina->oficina_estado == 1)
                                                Activo
                                            @else
                                                Baja
                                            @endif
                                        
                                        </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Sucursal</label>
                               
                                <div class="col-lg-3">
                                    <p class="form-control-static">
                                        <a href="{{ route('dispositivos.show', $oficina->sucursal->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                            {{  $oficina->sucursal->sucursal_nombre }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Dispositivo</label>
                                <div class="col-lg-3">
                                    <p class="form-control-static">
                                        <a href="{{ route('dispositivos.show', $oficina->dispositivo->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                            {{  $oficina->dispositivo->dispositivo_nombre }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('oficinas.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('oficinas.edit', $oficina->id) }}">
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
