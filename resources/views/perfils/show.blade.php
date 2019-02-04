@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Perfil / Ver #{{$perfil->id}}
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
                                <div class="col-lg-6">
                                    <p class="form-control-static">{{  $perfil->perfil_nombre }} </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Descripción</label>
                                <div class="col-lg-6">
                                    <p class="form-control-static">{{  $perfil->perfil_descripcion }} </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Permisos</label>
                                <div class="col-lg-6">
                                     @foreach($perfil->permisos as $permiso)
                                        <p class="form-control-static">	{{ $permiso->permiso_nombre }} </p>
                                    @endforeach
                                   
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Modulos</label>
                                <div class="col-lg-6">
                                     @foreach($perfil->Modulos as $modulo)
                                        <p class="form-control-static">	{{ $modulo->modulo_nombre }} </p>
                                    @endforeach
                                   
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('perfils.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('perfils.edit', $perfil->id) }}">
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