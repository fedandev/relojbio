@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Turno / Ver {{$turno->turno_nombre}}
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
                                <div class="col-lg-10"><p class="form-control-static">{{  $turno->turno_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Lunes</label>
                                <div class="col-lg-1">
                                    <p class="form-control-static">
                                        @if($turno->turno_lunes == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                                <label class="col-lg-2 control-label">Aplica Medio Horario?</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static">
                                        @if($turno->turno_lunes_mh == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Martes</label>
                                <div class="col-lg-1">
                                    <p class="form-control-static">
                                        @if($turno->turno_martes == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                                <label class="col-lg-2 control-label">Aplica Medio Horario?</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static">
                                        @if($turno->turno_martes_mh == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Miercoles</label>
                                <div class="col-lg-1">
                                    <p class="form-control-static">
                                        @if($turno->turno_miercoles == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                                <label class="col-lg-2 control-label">Aplica Medio Horario?</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static">
                                        @if($turno->turno_miercoles_mh == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Jueves</label>
                                <div class="col-lg-1">
                                    <p class="form-control-static">
                                        @if($turno->turno_jueves == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                                <label class="col-lg-2 control-label">Aplica Medio Horario?</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static">
                                        @if($turno->turno_jueves_mh == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Viernes</label>
                                <div class="col-lg-1">
                                    <p class="form-control-static">
                                        @if($turno->turno_viernes == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                                <label class="col-lg-2 control-label">Aplica Medio Horario?</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static">
                                        @if($turno->turno_viernes_mh == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Sabado</label>
                                <div class="col-lg-1">
                                    <p class="form-control-static">
                                        @if($turno->turno_sabado == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                                <label class="col-lg-2 control-label">Aplica Medio Horario?</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static">
                                        @if($turno->turno_sabado_mh == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Domingo</label>
                                <div class="col-lg-1">
                                    <p class="form-control-static">
                                        @if($turno->turno_domingo == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                                
                                <label class="col-lg-2 control-label">Aplica Medio Horario?</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static">
                                        @if($turno->turno_domingo_mh == "1")
                                            <i class="fa fa-check text-navy"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif    
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                           
                            <div class="form-group"><label class="col-lg-2 control-label">Horario</label>
                                <div class="col-lg-10"><p class="form-control-static"><a href="{{ route('horarios.show', $turno->horario->id) }}" target="_blank">{{  $turno->horario->horario_nombre }}</a> </p></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Hora Entrada</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $turno->horario->horario_entrada }} </p></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Hora Salida</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $turno->horario->horario_salida }} </p></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('turnos.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('turnos.edit', $turno->id) }}">
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
