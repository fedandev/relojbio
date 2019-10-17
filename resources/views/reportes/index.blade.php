@extends('layouts.app')

@section('content')
    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Reporte
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    
                  
                    
                    <div class="ibox-content">
                        
                        <form action="{{ route('reportes.horasTrabajadasEmpleado') }}" method="POST" accept-charset="UTF-8" class="form-horizontal" id="frmReportes">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fecha Inicio</label>
                                <div class="col-sm-3"><input class="form-control" type="date" name="fechainicio" id="fechainicio" required value="{{ old('fechainicio') }}"></div>
                            </div>
                            
                            
                           
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fecha Fin</label>
                                <div class="col-sm-3"><input class="form-control" type="date" name="fechafin" id="fechafin" required value="{{ old('fechafin') }}"></div>
                            </div>
                            
                            
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Empleado</label>
                                <div class="col-sm-4">
                                    <select class="select2_demo_2 form-control" name="fk_empleado_cedula" id="fk_empleado_cedula" required value="{{ old('fk_empleado_cedula') }}">
                                        @include('layouts.empleadosXcedula');
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group" id="div_oficina">
                                <label class="col-sm-2 control-label">Oficina</label>
                                <div class="col-sm-4">
                                    <input type="hidden" name="oficina" id="id_oficina" value="{{ old('fk_oficina_id') }}"/>
                                    <select class="select2_demo_2 form-control" name="fk_oficina_id" id="fk_oficina_id-field" >
                                        @include('layouts.oficinas')
                                    </select>
                                </div>
                            </div> 
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Reportes de empleado</label>
                                <div class="col-sm-4">
                                    <select class="select2_demo_2 form-control" name="tiporeporte" id="tiporeporte-field" required value="{{ old('tiporeporte') }}">
                                        @include('layouts.reportesXempleado');
                                    </select>
                                </div>
                            </div>
                            
                             <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('reportes.index') }}" > Cancelar</a>
                                    <button class="btn btn-primary" type="submit">Ver</button>
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
            $("#tiporeporte-field").change(function() {
                var reporte = $("#tiporeporte-field").val();
                var action = '/';
              
                if(reporte =='ht'){
                    action = '/reportes/horasTrabajadasEmpleado';
                }else if(reporte =='lt'){
                    action = '/reportes/llegadasTarde';
                }else if(reporte =='sa'){
                    action = '/reportes/salidasAntes';
                }else if(reporte =='hn'){
                    action = '/reportes/horasNocturnas';
                }else if(reporte =='he'){
                    action = '/reportes/horasExtras';
                }else if(reporte =='lf'){
                    action = '/reportes/listadoFaltas';
                }else if(reporte =='es'){
                    action = '/reportes/entradasYsalidas';
                }else if(reporte == 'lc'){
                    action = '/reportes/libresConcedidos';
                }else if(reporte == 'her'){
                    action = '/reportes/HorasExtrasResumidas';
                }else if(reporte == 'rm'){
                    action = '/reportes/registrosManual';
                }else if(reporte == 'esm'){
                    action = '/reportes/empleadosMarcasAyer';
                }
                
                $("#frmReportes").attr("action", action);
            });
            
            $('#date_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
            
            var oficina = $('#id_oficina').val();
            $('#fk_oficina_id-field option').each(function() {
                if($(this).val() ==  oficina) {
                    $(this).prop("selected", true);
                }
            });
           
            
            $("#fk_empleado_cedula").change(function() {
                var empleado = $("#fk_empleado_cedula").val();
                
                if(empleado == 'ALL') {
                    $('#div_oficina').show();
                }else{
                    $('#div_oficina').hide();
                    
                }
            });
            
            $("#fk_oficina_id-field").change(function() {
                var oficina = $("#fk_oficina_id-field").val();
                
                if(oficina == '') {
                    $("#fk_empleado_cedula").val('');
                    $("#fk_empleado_cedula").prop("disabled",false);
                }else{
                  
                    $('#fk_empleado_cedula option:selected').removeAttr('selected');
                    $("#fk_empleado_cedula").val('ALL').trigger('change');
                    
                    
                }
            });
            $(".select2_demo_2").select2();
        });
    </script>
@endsection