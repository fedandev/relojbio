@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Libres Concedidos /
                            @if($libre_detalle->id)
                                Editar #{{$libre_detalle->id}}
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
                        
                        @if($libre_detalle->id)
                            <form action="{{ route('libre_detalles.update', $libre_detalle->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('libre_detalles.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Fecha Desde</label>
                                    <div class="col-sm-2"><input class="form-control" type="date" name="fecha_desde" id="fecha_desde-field" value="{{ old('fecha_desde', $libre_detalle->fecha_desde ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Fecha Hasta</label>
                                    <div class="col-sm-2"><input class="form-control" type="date" name="fecha_hasta" id="fecha_hasta-field" value="{{ old('fecha_hasta', $libre_detalle->fecha_hasta ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo Libre</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_tipo_libre_id" id="fk_tipo_libre_id-field" value="{{ old('fk_tipo_libre_id', $libre_detalle->fk_tipo_libre_id ) }}">
                                            @include('layouts.tipolibres')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empleado</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_empleado_id" id="fk_empleado_id-field" value="{{ old('fk_empleado_id', $libre_detalle->fk_empleado_id ) }}">
                                            @include('layouts.empleados')
                                        </select>

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Observaciones </label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="comentarios" id="comentarios-field" value="{{ old('comentarios', $libre_detalle->comentarios ) }}"></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('libre_detalles.index') }}"> Cancelar</a>
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
<script >
     $(document).ready(function() {
        var empleado_id = $("#fk_empleado_id-field").attr('value');
        if(empleado_id>0){
            $('#fk_empleado_id-field option[value="'+ empleado_id +'"]').prop("selected", true);
        }
             
        var tipolibre_id = $("#fk_tipo_libre_id-field").attr('value');
        if(tipolibre_id>0){
            $('#fk_tipo_libre_id-field option[value="'+ tipolibre_id +'"]').prop("selected", true);
        }
         
        $(".select2_demo_2").select2();
    });
</script>
@endsection