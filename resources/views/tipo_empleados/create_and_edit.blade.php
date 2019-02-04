@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Tipo Empleado /
                            @if($tipo_empleado->id)
                                Editar #{{$tipo_empleado->tipoempleado_nombre}}
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
                        
                        @if($tipo_empleado->id)
                            <form action="{{ route('tipo_empleados.update', $tipo_empleado->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('tipo_empleados.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="tipoempleado_nombre" id="tipoempleado_nombre-field" value="{{ old('tipoempleado_nombre', $tipo_empleado->tipoempleado_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="tipoempleado_descripcion" id="tipoempleado_descripcion-field" value="{{ old('tipoempleado_descripcion', $tipo_empleado->tipoempleado_descripcion ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo Horario</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_tipohorario_id" id="fk_tipohorario_id-field" value="{{ old('fk_tipohorario_id', $tipo_empleado->fk_tipohorario_id ) }}">
                                            @include('layouts.tipohorarios')
                                        </select>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                 
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('tipo_empleados.index') }}"> Cancelar</a>
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
            
             var tipohorario_id = $("#fk_tipohorario_id-field").attr('value');
            if(tipohorario_id>0){
                $('#fk_tipohorario_id-field option[value="'+ tipohorario_id +'"]').prop("selected", true);
            }
            
            $(".select2_demo_2").select2();
        });
                  
    </script>
    
@endsection