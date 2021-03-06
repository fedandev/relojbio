@extends('layouts.app')

@section('content')
   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Sucursal /
                            @if($sucursal->id)
                                Editar #{{$sucursal->id}}
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
                        @if($sucursal->id)
                            <form action="{{ route('sucursals.update', $sucursal->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('sucursals.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="sucursal_nombre" id="sucursal_nombre-field" value="{{ old('sucursal_nombre', $sucursal->sucursal_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="sucursal_descripcion" id="sucursal_descripcion-field" value="{{ old('sucursal_descripcion', $sucursal->sucursal_descripcion ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empresa</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_empresa_id" id="fk_empresa_id-field" value="{{ old('fk_empresa_id', $sucursal->fk_empresa_id ) }}">
                                            @include('layouts.empresas')
                                        </select>
                                    </div>
                                </div>
                                
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('sucursals.index') }}"> Cancelar</a>
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
            var empresa_id = $("#fk_empresa_id-field").attr('value');
            if(empresa_id>0){
                $('#fk_empresa_id-field option[value="'+ empresa_id +'"]').prop("selected", true);
            }
            $(".select2_demo_2").select2();
        });
    </script>
@endsection