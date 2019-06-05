@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Asignar Horario /
                            @if($trabaja->id)
                                Editar #{{$trabaja->id}}
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
                        
                        @if($trabaja->id)
                            <form action="{{ route('trabajas.update', $trabaja->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('trabajas.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empleado</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_empleado_id" id="fk_empleado_id-field" value="{{ old('fk_empleado_id', $trabaja->fk_empleado_id ) }}">
                                            @include('layouts.empleados')
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="data_2">
                                    <label class="col-sm-2 control-label">Fecha Inicio</label>
                                    <div class="col-sm-2">
                                        <div class="input-group date">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" class="form-control" name="trabaja_fechainicio" id="trabaja_fechainicio-field" value="{{ old('trabaja_fechainicio', $trabaja->trabaja_fechainicio ) }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group" id="data_2">
                                    <label class="col-sm-2 control-label">Fecha Fin</label>
                                    <div class="col-sm-2">
                                        <div class="input-group date">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" class="form-control" name="trabaja_fechafin" id="trabaja_fechafin-field" value="{{ old('trabaja_fechafin', $trabaja->trabaja_fechafin ) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo de Horario</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="tipohorario" id="tipohorario">
                                            <option value="Fijo">Fijo</option>
                                            <option value="Rotativo">Rotativo</option>
                                            <option value="Semanal">Semanal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="turno" >
                                    <label class="col-sm-2 control-label">Horario de Turno</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_turno_id" id="fk_turno_id-field" value="{{ $trabaja->fk_turno_id  }}">
                                            @include('layouts.turnos')
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="rotativo" >
                                    <label class="col-sm-2 control-label">Horario Rotativo</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_horariorotativo_id" id="fk_horariorotativo_id-field"  value="{{ old('fk_horariorotativo_id', $trabaja->fk_horariorotativo_id )}}">
                                            @include('layouts.horarios_rotativos')
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="semanal" >
                                    <label class="col-sm-2 control-label">Horario Semanal</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_horariosemanal_id" id="fk_horariosemanal_id-field" value="{{ old('fk_horariosemanal_id', $trabaja->fk_horariosemanal_id ) }}">
                                            @include('layouts.horarios_semanales')
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('trabajas.index') }}"> Cancelar</a>
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
            $('#data_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
            
            
            
            $('#turno').hide();
            $('#rotativo').hide();
            $('#semanal').hide();
            
            //cargo valor de tipo horario segun la fk que tenga cargada
            
            var fijo =  $("#fk_turno_id-field").attr('value');
            var semanal =  $("#fk_horariosemanal_id-field").attr('value');
            var rotativo =  $("#fk_horariorotativo_id-field").attr('value');
            if(fijo>0){
                $('#tipohorario option[value="Fijo"]').prop("selected", true);
                $('#fk_turno_id-field option[value="'+ fijo +'"]').prop("selected", true);
                $("#fk_turno_id-field").prop('required',true);
            }
           
            if(semanal>0){
                $('#tipohorario option[value="Semanal"]').prop("selected", true);
                $('#fk_horariosemanal_id-field option[value="'+ semanal +'"]').prop("selected", true);
                $("#fk_horariosemanal_id-field").prop('required',true);
            }
            
            if(rotativo>0){
                $('#tipohorario option[value="Rotativo"]').prop("selected", true);
                $('#fk_horariorotativo_id-field option[value="'+ rotativo +'"]').prop("selected", true);
                $("#fk_horariorotativo_id-field").prop('required',true);
            }
            
            
            var empleado_id = $("#fk_empleado_id-field").attr('value');
            if(empleado_id>0){
                $('#fk_empleado_id-field option[value="'+ empleado_id +'"]').prop("selected", true);
            }
            
            
            cambiarCombos();
            
            $(".select2_demo_2").select2();
        });
        
        $("#tipohorario").change(function(event){
            
            $("#fk_turno_id-field").val('0');
            $("#fk_horariosemanal_id-field").val('0');
            $("#fk_horariorotativo_id-field").val('0');
            cambiarCombos();
        });
        
        function cambiarCombos(){
            var value =  $("#tipohorario").val();
 
            if(value == "Fijo"){
                $('#turno').show();
                $('#rotativo').hide();
                $('#semanal').hide();
                $("#fk_turno_id-field").prop('required',true);
                $("#fk_horariosemanal_id-field").prop('required',false);
                $("#fk_horariorotativo_id-field").prop('required',false);
            }else if(value == "Semanal"){
                $('#turno').hide();
                $('#rotativo').hide();
                $('#semanal').show();
                $("#fk_horariosemanal_id-field").prop('required',true);
                $("#fk_horariorotativo_id-field").prop('required',false);
                $("#fk_turno_id-field").prop('required',false);
            }else if(value == "Rotativo"){
                $('#turno').hide();
                $('#rotativo').show();
                $('#semanal').hide();
                $("#fk_horariorotativo_id-field").prop('required',true);
                $("#fk_turno_id-field").prop('required',false);
                $("#fk_horariosemanal_id-field").prop('required',false);
            }
            
        }
        
        
    </script>
    
@endsection