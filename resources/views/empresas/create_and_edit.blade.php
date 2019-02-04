@extends('layouts.app')

@section('content')
<?php use App\Models\Empresa; ?>
    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Empresas /
                            @if($empresa->id)
                                Editar #{{$empresa->id}}
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
                        
                        
                        @if($empresa->id)
                            <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('empresas.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="empresa_nombre" id="empresa_nombre-field" value="{{ old('empresa_nombre', $empresa->empresa_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Teléfono</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="empresa_telefono" id="empresa_telefono-field" value="{{ old('empresa_telefono', $empresa->empresa_telefono ) }}"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Estado </label>

                                    <div class="col-sm-6">
                                        <div class="i-checks">
                                            <label> 
                                                <input type="radio" name="empresa_estado" id="empresa_estado-field" value="1" {{ $empresa->empresa_estado == 1 ? 'checked' : '' }}> <i></i>
                                                Activo 
                                            </label>
                                        </div>
                                        <div class="i-checks">
                                            <label> 
                                                <input type="radio" name="empresa_estado" id="empresa_estado-field" value="0" {{ $empresa->empresa_estado == 0 ? 'checked' : '' }}> <i></i>
                                                Baja
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Ingreso</label>
                                    <div class="col-sm-2">
                                        <input class="form-control" type="date" name="empresa_ingreso" id="empresa_ingreso-field" value="{{ old('empresa_ingreso', $empresa->empresa_ingreso ) }}">    
                                    </div>
                                </div>
                             
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('empresas.index') }}"> Cancelar</a>
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

