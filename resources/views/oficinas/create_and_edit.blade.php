@extends('layouts.app')

@section('content')
<?php use App\Models\Oficina; ?>
    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Oficina /
                            @if($oficina->id)
                                Editar #{{$oficina->id}}
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
      
                        @if($oficina->id)
                            <form action="{{ route('oficinas.update', $oficina->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('oficinas.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="oficina_nombre" id="oficina_nombre-field" value="{{ old('oficina_nombre', $oficina->oficina_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="oficina_descripcion" id="oficina_descripcion-field" value="{{ old('oficina_descripcion', $oficina->oficina_descripcion ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Código</label>
                                    <div class="col-sm-3"><input class="form-control" type="text" name="oficina_codigo" id="oficina_codigo-field" value="{{ old('oficina_codigo', $oficina->oficina_codigo ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Estado</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="oficina_estado" id="oficina_estado-field" value="{{ old('oficina_estado', $oficina->oficina_estado ) }}">
                                            <option value="1"> Activo</option>
                                            <option value="0"> Baja</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Sucursal</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_sucursal_id" id="fk_sucursal_id-field" value="{{ old('fk_sucursal_id', $oficina->fk_sucursal_id ) }}">
                                            @include('layouts.sucursales')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Dispositivo</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_dispositivo_id" id="fk_dispositivo_id-field" value="{{ old('fk_dispositivo_id', $oficina->fk_dispositivo_id ) }}">
                                            @include('layouts.dispositivos')
                                        </select>
                                    </div>
                                </div>
                                
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('oficinas.index') }}"> Cancelar</a>
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


@section('scripts')

    <script>
        $(document).ready(function(){
            
            
            var sucursal_id = $("#fk_sucursal_id-field").attr('value');
            if(sucursal_id>0){
                $('#fk_sucursal_id-field option[value="'+ sucursal_id +'"]').prop("selected", true);
            }
            
            var dispositivo_id = $("#fk_dispositivo_id-field").attr('value');
            if(dispositivo_id>0){
                $('#fk_dispositivo_id-field option[value="'+ dispositivo_id +'"]').prop("selected", true);
            }
            
            $(".select2_demo_2").select2();
        
        });
                  
    </script>
    
@endsection