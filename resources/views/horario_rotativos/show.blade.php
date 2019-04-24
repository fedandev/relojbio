@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Turno Rotativo / Ver "{{$horario_rotativo->horariorotativo_nombre}}"
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
                                <div class="col-lg-6"><p class="form-control-static">{{  $horario_rotativo->horariorotativo_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Día Comienzo</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $horario_rotativo->horariorotativo_diacomienzo }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Días de Trabajo</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $horario_rotativo->horariorotativo_diastrabajo }} </p></div>
                            </div>
                                
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Días Libres</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  $horario_rotativo->horariorotativo_diaslibres }} </p></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Horario</label>
                                <div class="col-lg-3">
                                    <p class="form-control-static">
                                        <a href="{{ route('horarios.show', $horario_rotativo->horario->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                            {{  $horario_rotativo->horario->horario_nombre }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('horario_rotativos.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('horario_rotativos.edit', $horario_rotativo->id) }}">
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