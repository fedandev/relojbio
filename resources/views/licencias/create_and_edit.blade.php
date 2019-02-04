@extends('layouts.app')

@section('content')
<?php use App\Models\Licencia; ?>
    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Licencia /
                            @if($licencia->id)
                                Editar #{{$licencia->id}}
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
                    
                    @include('common.error')
                    
                    <div class="ibox-content">
                        @if($licencia->id)
                            <form action="{{ route('licencias.update', $licencia->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('licencias.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Año</label>
                                    <div class="col-sm-2"><input class="form-control" type="number" name="licencia_anio" id="licencia_anio-field" value="{{ old('licencia_anio', $licencia->licencia_anio ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Cantidad de días </label>
                                    <div class="col-sm-2"><input class="form-control" type="number" name="licencia_cantidad" id="licencia_cantidad-field" value="{{ old('licencia_cantidad', $licencia->licencia_cantidad ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Observaciones </label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="licencia_observaciones" id="licencia_observaciones-field" value="{{ old('licencia_observaciones', $licencia->licencia_observaciones ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo Licencia</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_tipolicencia_id" id="fk_tipolicencia_id-field" value="{{ old('fk_tipolicencia_id', $licencia->fk_tipolicencia_id ) }}">
                                            @include('layouts.tipolicencias')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empleado</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_empleado_id" id="fk_empleado_id-field" value="{{ old('fk_empleado_id', $licencia->fk_empleado_id ) }}">
                                            @include('layouts.empleados')
                                        </select>

                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('licencias.index') }}"> Cancelar</a>
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
        
        
        var tipolicencias_id = $("#fk_tipolicencia_id-field").attr('value');
        if(tipolicencias_id>0){
            $('#fk_tipolicencia_id-field option[value="'+ tipolicencias_id +'"]').prop("selected", true);
        }
        
        var empleado_id = $("#fk_empleado_id-field").attr('value');
        if(empleado_id>0){
            $('#fk_empleado_id-field option[value="'+ empleado_id +'"]').prop("selected", true);
        }
        
        $(".select2_demo_2").select2();
    });
</script>
@endsection

