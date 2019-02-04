@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Licencia / Ver #{{$licencia->id}}
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
                                <label class="col-lg-2 control-label">Año de la licencia</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $licencia->licencia_anio }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Cantidad de días</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $licencia->licencia_cantidad }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Observaciones </label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $licencia->licencia_observaciones }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                           
                            <div class="form-group"><label class="col-lg-2 control-label">Tipo de Licencia</label>
                                <div class="col-lg-3"><p class="form-control-static">{{  $licencia->tipolicencia->tipolicencia_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Empleado </label>
                                <div class="col-lg-3"><p class="form-control-static">{{  $licencia->empleado->empleado_nombre }} {{  $licencia->empleado->empleado_apellido }}</p></div>
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('licencias.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('licencias.edit', $licencia->id) }}">
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
