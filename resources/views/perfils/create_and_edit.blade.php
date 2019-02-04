@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Perfil /
                            @if($perfil->id)
                                Editar #{{$perfil->id}}
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
                        
                        @if($perfil->id)
                            <form action="{{ route('perfils.update', $perfil->id) }}" method="POST"  class="form-horizontal" accept-charset="UTF-8">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('perfils.store') }}" method="POST" accept-charset="UTF-8"  class="form-horizontal">
                        @endif
        
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
                            
                            <div class="form-group">
                            	<label for="perfil_nombre-field" class="col-sm-2 control-label">Nombre (*)</label>
                            	<div class="col-sm-6">
                            	    <input class="form-control" type="text" name="perfil_nombre" id="perfil_nombre-field" value="{{ old('perfil_nombre', $perfil->perfil_nombre ) }}" />
                            	</div>
                            </div> 
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                            	<label for="perfil_descripcion-field" class="col-sm-2 control-label">Descripción</label>
                            	<div class="col-sm-6">
                                	<input class="form-control" type="text" name="perfil_descripcion" id="perfil_descripcion-field" value="{{ old('perfil_descripcion', $perfil->perfil_descripcion ) }}" />
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                               
                                <label class="col-sm-2 control-label">Permisos (*)</label>
                                
                                <div class="col-sm-10">
                                    @foreach($g_permisos as $permiso)
                                        <div class="i-checks">
                                            <label> 
                                                <input type="checkbox" name="v_permisos[]" id="v_permisos" value="{{ $permiso->id }}" {{ $perfil->permisos->contains($permiso->id) ? 'checked' : '' }}> <i></i>
                                                {{ $permiso->permiso_nombre }} 
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        
                            <div class="hr-line-dashed"></div>
                        
                            <div class="form-group">
                               
                                <label class="col-sm-2 control-label">Modulos (*)</label>
                                
                                <div class="col-sm-10">
                                    @foreach($g_modulos as $modulo)
                                        <div class="i-checks">
                                            <label> 
                                                <input type="checkbox" name="v_modulos[]" id="v_modulos" value="{{ $modulo->id }}" {{ $perfil->Modulos->contains($modulo->id) ? 'checked' : '' }}> <i></i>
                                                {{ $modulo->modulo_nombre }} 
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        
                        
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('perfils.index') }}"> Cancelar</a>
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


