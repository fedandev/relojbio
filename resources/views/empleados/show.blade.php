@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Empleado / Ver #{{$empleado->id}}
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
                                <label class="col-sm-2 control-label">Cédula</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->empleado_cedula }} </p></div>
                                
                                <label class="col-sm-1 control-label">Código</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->empleado_codigo }} </p></div>
                           
                                
                            </div>
                            
                  
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->empleado_nombre }} </p></div>
                            
                                <label class="col-sm-1 control-label">Apellido</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->empleado_apellido }} </p></div>
                            
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                
                                <label class="col-sm-2 control-label">Correo</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->empleado_correo }} </p></div>
                            
                                <label class="col-sm-1 control-label">Teléfono</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->empleado_telefono }} </p></div>
                            
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">F. Ingreso</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->empleado_fingreso }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tipo Empleado</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->tipoempleado->tipoempleado_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Oficina</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->oficina->oficina_nombre }} </p></div>
                            
                                <label class="col-sm-1 control-label">Sucursal</label>
                                <div class="col-sm-3"><p class="form-control-static">{{  $empleado->oficina->sucursal->sucursal_nombre }} </p></div>
                            
                            </div>
                          
                           
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('empleados.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('empleados.edit', $empleado->id) }}">
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
