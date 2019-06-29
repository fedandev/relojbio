@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Autorización / Ver "#{{$autorizacion->id}}"
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
                                <label class="col-lg-2 control-label">Empleado</label>
                                <div class="col-lg-10"><p class="form-control-static"><a href="{{ route('empleados.show', $autorizacion->empleado->id) }}" target="_blank">{{$autorizacion->empleado->empleado_nombre}} {{$autorizacion->empleado->empleado_apellido}} </a></p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Fecha Desde</label>
                                <div class="col-lg-10"><p class="form-control-static">{{formatFecha($autorizacion->autorizacion_fechadesde) }}</p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Fecha Hasta</label>
                                <div class="col-lg-10"><p class="form-control-static">{{formatFecha($autorizacion->autorizacion_fechahasta) }}</p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Antes de Hora</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">
                                        @if ($autorizacion->autorizacion_antesHorario == '1')
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Despues de Hora</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">
                                        @if ($autorizacion->autorizacion_despuesHorario == '1')
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                      
                            <div class="form-group"><label class="col-lg-2 control-label">Descripción</label>
                                <div class="col-lg-10"><p class="form-control-static">{{$autorizacion->autorizacion_descripcion }}</p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('autorizacions.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('autorizacions.edit', $autorizacion->id) }}">
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
