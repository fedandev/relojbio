@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Horario Asignado / Ver #{{$trabaja->id}}
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                   
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group"><label class="col-lg-2 control-label">Empleado</label>
                                <div class="col-lg-10"><p class="form-control-static">{{$trabaja->empleado->empleado_nombre}} {{$trabaja->empleado->empleado_apellido}}</p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Fecha Inicio</label>
                                <div class="col-lg-10"><p class="form-control-static">{{ $trabaja->trabaja_fechainicio }} </p></div>
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                           
                            <div class="form-group"><label class="col-lg-2 control-label">Fecha Fin</label>
                                <div class="col-lg-10"><p class="form-control-static">{{ $trabaja->trabaja_fechafin }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Tipo Horario</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">
                                        @if(isset($trabaja->fk_horariorotativo_id))
                                            Rotativo
                                        @elseif(isset($trabaja->fk_turno_id))
                                            Fijo
                                        @elseif(isset($trabaja->fk_horariosemanal_id))
                                            Semanal
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                             <div class="form-group"><label class="col-lg-2 control-label">Nombre Horario</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">
                                        @if(isset($trabaja->fk_horariorotativo_id))
                                            {{$trabaja->horariorotativo->horariorotativo_nombre}}
                                        @elseif(isset($trabaja->fk_turno_id))
                                            {{$trabaja->turno->turno_nombre}}
                                        @elseif(isset($trabaja->fk_horariosemanal_id))
                                            {{$trabaja->horariosemanal->horariosemanal_nombre}}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('trabajas.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('trabajas.edit', $trabaja->id) }}">
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
