@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Empleado /
                            @if($empleado->id)
                                Editar #{{$empleado->id}}
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
                    
                        @if($empleado->id)
                            <form action="{{ route('empleados.update', $empleado->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('empleados.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label p-xxs">Cédula</label>
                                    <div class="col-sm-3"><input class="form-control" type="text" name="empleado_cedula" id="empleado_cedula-field" value="{{ old('empleado_cedula', $empleado->empleado_cedula ) }}"></div>
                                
                                    <label class="col-sm-1 control-label p-xxs">Código</label>
                                    <div class="col-sm-3"><input class="form-control" type="text" name="empleado_codigo" id="empleado_codigo-field" value="{{ old('empleado_codigo', $empleado->empleado_codigo ) }}"></div>
                            
                                </div>
                              
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-3"><input class="form-control" type="text" name="empleado_nombre" id="empleado_nombre-field" value="{{ old('empleado_nombre', $empleado->empleado_nombre ) }}"></div>
                                
                                    <label class="col-sm-1 control-label">Apellido</label>
                                    <div class="col-sm-3"><input class="form-control" type="text" name="empleado_apellido" id="empleado_apellido-field" value="{{ old('empleado_apellido', $empleado->empleado_apellido ) }}"></div>
                                
                                </div>
                                 
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Correo</label>
                                    <div class="col-sm-3"><input class="form-control" type="text" name="empleado_correo" id="empleado_correo-field" value="{{ old('empleado_correo', $empleado->empleado_correo ) }}"></div>
                                
                                    <label class="col-sm-1 control-label">Teléfono</label>
                                    <div class="col-sm-3"><input class="form-control" type="text" name="empleado_telefono" id="empleado_telefono-field" value="{{ old('empleado_telefono', $empleado->empleado_telefono ) }}"></div>
                                
                                </div>
                                  
                               
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">F. Ingreso</label>
                                    <div class="col-sm-3"><input class="form-control" type="date" name="empleado_fingreso" id="empleado_fingreso-field" value="{{ old('empleado_fingreso', $empleado->empleado_fingreso ) }}"></div>
                                </div>
                             
                              
                               <div class="form-group">
                                    <label class="col-sm-2 control-label">F. Vencimiento Cedula</label>
                                    <div class="col-sm-3"><input class="form-control" type="date" name="empleado_fec_venc_cedula" id="empleado_fec_venc_cedula-field" value="{{ old('empleado_fec_venc_cedula', $empleado->empleado_fec_venc_cedula ) }}"></div>
                                    
                                    <label class="col-sm-1 control-label">Tipo Empleado</label>
                                    <div class="col-sm-3">
                                        <input type="hidden" name="tipoempleado" id="id_tipoempleado" value="{{ old('fk_tipoempleado_id', $empleado->fk_tipoempleado_id ) }}"/>
                                        <select class="select2_demo_2 form-control" name="fk_tipoempleado_id" id="fk_tipoempleado_id-field">
                                            @include('layouts.tipoempleados')
                                        </select>
                                    </div>
                                 
                                </div>
                              
                              <div class="form-group">
                                    <label class="col-sm-2 control-label">F. Vencimiento Licencia Conducir</label>
                                    <div class="col-sm-3"><input class="form-control" type="date" name="empleado_fec_venc_lic_cond" id="empleado_fec_venc_lic_cond-field" value="{{ old('empleado_fec_venc_lic_cond', $empleado->empleado_fec_venc_lic_cond ) }}"></div>
                                
                                     <label class="col-sm-1 control-label">Oficina</label>
                                    <div class="col-sm-3">
                                        <input type="hidden" name="oficina" id="id_oficina" value="{{ old('fk_oficina_id', $empleado->fk_oficina_id ) }}"/>
                                        <select class="select2_demo_2 form-control" name="fk_oficina_id" id="fk_oficina_id-field">
                                            @include('layouts.oficinas')
                                        </select>
                                    </div>
                                </div>
                              
                                
                              <div class="form-group">
                                    <label class="col-sm-2 control-label">Estado</label>
                                    <div class="col-sm-3">
                                        <input type="hidden" name="estado" id="estado" value="{{ old('empleado_estado', $empleado->empleado_estado ) }}"/>
                                        <select class="select2_demo_2 form-control" name="empleado_estado" id="empleado_estado-field" >
                                            <option value="Activo">Activo</option>
                                            <option value ="Baja">Baja</option>
                                        </select>
                                    </div>
                                </div>
                              
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('empleados.index') }}"> Cancelar</a>
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

    <script type="text/javascript">
        $(document).ready(function() {
            
            
            var oficina = $('#id_oficina').val();
            $('#fk_oficina_id-field option').each(function() {
                if($(this).val() ==  oficina) {
                    $(this).prop("selected", true);
                }
            });
            
            var tipoempleado = $('#id_tipoempleado').val();
            $('#fk_tipoempleado_id-field option').each(function() {
                if($(this).val() ==  tipoempleado) {
                    $(this).prop("selected", true);
                }
            });
            
          var estado = $('#estado').val();
            $('#empleado_estado-field option').each(function() {
                if($(this).val() ==  estado) {
                    $(this).prop("selected", true);
                }
            });
          
          
          
            $(".select2_demo_2").select2();
        });
    </script>
@endsection