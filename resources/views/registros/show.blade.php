@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Registro / Ver #{{ $registro->id }}
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
                                <div class="col-lg-2"><p class="form-control-static">{{  $registro->empleado->empleado_nombre ." ". $registro->empleado->empleado_apellido }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                      
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Fecha</label>
                                <div class="col-lg-2"><p class="form-control-static">{{ date( "d-m-Y", strtotime( $registro->registro_hora ) ) }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Hora</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  date( "H:i:s", strtotime( $registro->registro_hora ) ) }}</p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Tipo Registro</label>
                                <div class="col-lg-3">
                                    <p class="form-control-static">
                                        @if($registro->registro_tipo == "I")
                                                {{ "Entrada" }}
                                            @else
                                                {{ "Salida" }}
                                            @endif 
                                    </p>
                                </div>
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Dispositivo</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">
                                        @if(isset($registro->dispositivo->id))
                                            <a href="{{ route('dispositivos.show', $registro->dispositivo->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                                {{  $registro->dispositivo->dispositivo_nombre }}
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('registros.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('registros.edit', $registro->id) }}">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                    
                                     <a class="btn btn-success" href="{{ route('registros.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>


@endsection
