@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Modulo /
                            @if($modulo->id)
                                Editar #{{$modulo->id}}
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
                        
                        @if($modulo->id)
                            <form action="{{ route('modulos.update', $modulo->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('modulos.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">   

           
                                <div class="form-group">
                                	<label class="col-sm-2 control-label" for="modulo_nombre-field">Nombre</label>
                                	<div class="col-sm-4">
                                	    <input class="form-control" type="text" required name="modulo_nombre" id="modulo_nombre-field" value="{{ old('modulo_nombre', $modulo->modulo_nombre ) }}" />
                                    </div>
                                </div> 
                                
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                	<label class="col-sm-2 control-label" for="modulo_descripcion-field">Descripción</label>
                                	<div class="col-sm-4">
                                	    <input class="form-control" type="text" required name="modulo_descripcion" id="modulo_descripcion-field" value="{{ old('modulo_descripcion', $modulo->modulo_descripcion ) }}" />
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                   
                                    <label class="col-sm-2 control-label">Menus</label>
                                    
                                    <div class="col-sm-10">
                                        @foreach($g_menus as $menu)
                                            <div class="i-checks">
                                                <label> 
                                                    <input type="checkbox" name="v_menus[]" id="v_menus" value="{{ $menu->id }}" {{ $modulo->Menus->contains($menu->id) ? 'checked' : '' }}> <i></i>
                                                    {{ $menu->menu_descripcion }} 
                                                </label>
                                            </div>
                                        @endforeach
                                    
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('modulos.index') }}"> Cancelar</a>
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