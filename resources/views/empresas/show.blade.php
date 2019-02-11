@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Empresa / Ver "{{$empresa->empresa_nombre}}"
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
                                <div class="col-lg-10"><p class="form-control-static">{{  $empresa->empresa_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Telefono</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $empresa->empresa_telefono }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Telefono 2</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $empresa->empresa_telefono2 }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $empresa->empresa_email }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Email 2</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $empresa->empresa_email2 }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Estado</label>
                                <div class="col-lg-10"><p class="form-control-static"> 
                                    @if ($empresa->empresa_estado == 1)
                                        Habilitado
                                    @else
                                        Deshabilitado
                                    @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Ingreso</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  formatFecha($empresa->empresa_ingreso) }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('empresas.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('empresas.edit', $empresa->id) }}">
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