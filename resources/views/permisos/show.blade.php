@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Permiso / Ver "{{$permiso->permiso_nombre}}"
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
                                <div class="col-lg-10"><p class="form-control-static">{{  $permiso->permiso_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Habilitado</label>
                                <div class="col-lg-10">
                                        <p class="form-control-static">
                                            @if ($permiso->permiso_habilita == 1)
                                                Si
                                            @else
                                                No
                                            @endif
                                        
                                        </p>
                                </div>
                            </div>
                            
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('permisos.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('permisos.edit', $permiso->id) }}">
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
