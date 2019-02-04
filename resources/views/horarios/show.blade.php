@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Horario / Ver "{{$horario->horario_nombre}}"
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
                                <div class="col-lg-6"><p class="form-control-static">{{  $horario->horario_nombre }} </p></div>
                            </div>
                            
                             <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Hora Entrada</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $horario->horario_entrada }} </p></div>
                           
                                <label class="col-lg-2 control-label">Hora Salida</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $horario->horario_salida }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Aplica Brake?</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">
                                        @if($horario->horario_haybrake == "S")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                            </div>
                            
                            @if($horario->horario_haybrake == "S")
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Comiendo Brake</label>
                                    <div class="col-lg-2"><p class="form-control-static">{{  $horario->horario_comienzobrake }} </p></div>
                                    
                                    <label class="col-lg-2 control-label">Fin Brake</label>
                                    <div class="col-lg-2"><p class="form-control-static">{{  $horario->horario_finbrake }} </p></div>
                                    
                                </div>
                            @endif 
                            
                            
                            
                           
                            <div class="hr-line-dashed"></div>
                        
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tolerancia Llegada Tarde</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $horario->horario_tiempotarde }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tolerancia Salida Antes</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $horario->horario_salidaantes }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('horarios.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('horarios.edit', $horario->id) }}">
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