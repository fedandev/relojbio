@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Permiso /
                            @if($permiso->id)
                                Editar #{{$permiso->id}}
                            @else
                                Nuevo
                            @endif
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    
                   
                    
                    <div class="ibox-content">
                        @include('common.error')
                        

            
                        @if($permiso->id)
                            <form action="{{ route('permisos.update', $permiso->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('permisos.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="permiso_nombre" id="permiso_nombre-field" value="{{ old('permiso_nombre', $permiso->permiso_nombre  ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Habilitado </label>

                                    <div class="col-sm-10">
                                        <div class="i-checks">
                                            <label> 
                                                <input type="radio" name="permiso_habilita" id="permiso_habilita-field" value="1" {{ $permiso->permiso_habilita == 1 ? 'checked' : '' }}>  Si 
                                            </label>
                                        </div>
                                        <div class="i-checks">
                                            <label> 
                                                <input type="radio" name="permiso_habilita" id="permiso_habilita-field" value="0" {{ $permiso->permiso_habilita == 0 ? 'checked' : '' }}>   No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                 
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('permisos.index') }}"> Cancelar</a>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </div>
                                </div>
                                
                            </form>
     
                    </div>    
                </div>
            </div>
        </div>
    </div>
@endsection