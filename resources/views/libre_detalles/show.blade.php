@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Detalles de Libres / Ver #{{$libre_detalle->id}}
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
                                <label class="col-lg-2 control-label">Fecha Desde</label>
                                <div class="col-lg-6"><p class="form-control-static">{{  formatFecha($libre_detalle->fecha_desde) }} </p></div>
                            </div>
                            
                             <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Fecha Hasta</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  formatFecha($libre_detalle->fecha_hasta) }} </p></div>
                           </div>
                            
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tipo Libre</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $libre_detalle->tipoLibre->nombre }} </p></div>
                            </div>
                            
                           
                            <div class="hr-line-dashed"></div>
                        
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Empleado</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $libre_detalle->empleado->empleado_nombre }} {{  $libre_detalle->empleado->empleado_apellido }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Observaciones</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $libre_detalle->comentarios }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('libre_detalles.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <!--<a class="btn btn-default" href="{{ route('libre_detalles.edit', $libre_detalle->id) }}">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>-->
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>


@endsection