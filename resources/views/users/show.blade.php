@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Usuario / Ver #{{$user->id}}
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                   
                    
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $user->email }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                             
                            <div class="form-group"><label class="col-lg-2 control-label">Nombre</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $user->nombre }} </p></div>
                            </div>
                            
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Observaciones</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $user->observaciones }} </p></div>
                            </div>
                            
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Estado</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $user->estado }} </p></div>
                            </div>
                            
                             <div class="hr-line-dashed"></div>
                            @if($user->empleado)
                            <div class="form-group"><label class="col-lg-2 control-label">Empleado </label>
                                <div class="col-lg-3">
                                    <p class="form-control-static">
                                    
                                     <a href="{{ route('empleados.show', $user->empleado->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                            {{  $user->empleado->empleado_nombre }} {{  $user->empleado->empleado_apellido }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            @endif
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Perfiles</label>
                                <div class="col-lg-10">
                                     @foreach($user->Perfiles as $perfil)
                                        <p class="form-control-static">
                                            <a href="{{ route('perfils.show', $perfil->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                                {{  $perfil->perfil_nombre }}
                                            </a>
                                        </p>
                                        
                                    @endforeach
                                   
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('users.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('users.edit', $user->id) }}">
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
