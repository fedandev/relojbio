@extends('layouts.app')

@section('content')
<?php
    $eliminar = array('{','}','"');
    $exceptions = array(
        "empleado_cedula" => "Cedula",
        "empleado_codigo"  => "Código", 
        "empleado_nombre"  => "Nombre",
        "empleado_apellido"  => "Apellido",
        "empleado_correo"  => "Correo",
        "empleado_telefono"  => "Teléfono",
        "empleado_fingreso"  => "F. Ingreso",
        "fk_tipoempleado_id"  => "Tipo Empleado ID",
        "fk_oficina_id" => "Oficina ID",
        "id" => "ID",
        "ajuste_nombre" => "Nombre de ajuste",
        "ajuste_valor" => "Valor de ajuste",
        "ajuste_descripcion" => "Descripción de ajuste",
        "dispositivo_nombre" => "Nombre de dispositivo",
        "dispositivo_serial" => "Serial de dispositivo",
        "dispositivo_modelo" => "Modelo de dispositivo",
        "dispositivo_ip" => "IP de dispositivo",
        "dispositivo_puerto" => "Puerto de dispositivo",
        "dispositivo_usuario" => "Usuario de dispositivo",
        "dispositivo_password" => "Passoword de dispositivo",
        "empresa_nombre" => "Nombre de la empresa",
        "empresa_telefono" => "Telefono de la empresa",
        "empresa_ingreso" => "F. Ingreso de la empresa",
        "feriado_nombre" => "Nombre del feriado",
        "feriado_coeficiente" => "Coeficiente del feriado",
        "feriado_minimo" => "Mínimo del feriado",
        "feriado_fecha" => "Fecha del feriado",
        "horario_nombre" => "Nombre del horario",
        "horario_entrada" => "Entrada del horario",
        "horario_salida" => "Salida del horario",
        "horario_comienzobrake" => "Inicio brake del horario",
        "horario_finbrake" => "Fin brake del horario",
        "horario_tiempotarde" => "Tiempo tarde del horario",
        "horario_salidaantes" => "Salida antes del horario",
        "horariorotativo_nombre" => "Nombre del horario rot.",
        "horariorotativo_diacomienzo" => "Día comienzo del horario rot.",
        "horariorotativo_diastrabajo" => "Días del trab. del horario rot.",
        "horariorotativo_diaslibres" => "Días libre del horario rot.",
        "horariosemanal_nombre" => "Nombre del horario semanal",
        "horariosemanal_horas" => "Horas del horario semanal",
        "licencia_anio" => "Año de licencia",
        "licencia_cantidad" => "Cant. de días de licencia",
        "licencia_observaciones" => "Observaciones de licencia",
        "menu_padre_id" => "Padre ID",
        "menu_descripcion" => "Descripcion Menu",
        "menu_posicion" => "Posicioón del Menu",
        "menu_habilitado" => "Habilitado",
        "menu_url" => "URL del menu",
        "menu_icono" => "Icono del menu",
        "menu_formulario" => "Formulario del menu",
        "modulo_nombre" => "Nombre modulo",
        "modulo_descripcion" => "Descripción modulo",
        "oficina_nombre" => "Nombre oficina",
        "oficina_descripcion" => "Descripción oficina",
        "oficina_codigo" => "Código oficina",
        "oficina_estado" => "Estado oficina",
        "fk_dispositivo_id" => "Id Dispositivo",
        "perfil_nombre" => "Nombre perfil",
        "perfil_descripcion" => "Descripcion perfil",
        "permiso_nombre" => "Nombre permiso",
        "permiso_habilita" => "Permiso",
        "registro_hora" => "Hora registro",
        "registro_fecha" => "Fecha registro",
        "registro_tipomarca" => "Tipo marca registro",
        "registro_comentarios" => "Comentarios registro",
        "registro_registrado" => "Registrado",
        "registro_tipo" => "Tipo registro",
        "fk_empleado_cedula" => "Cedula empleado",
        "sucursal_nombre" => "Nombre sucursal",
        "sucursal_descripcion" => "Descripción sucursal",
        "tipoempleado_nombre" => "Nombre tipo empleado",
        "tipoempleado_descripcion" => "Descripcion tipo empelado",
        "fk_tipohorario_id" => "ID tipo horario",
        "tipohorario_nombre" => "Nombre tipo horario",
        "tipohorario_descripcion" => "Descripción tipo horario",
        "tipolicencia_nombre" => "Nombre tipo licencia",
        "tipolicencia_descripcion" => "Descripción tipo licencia",
        "trabaja_fechainicio" => "Fecha inicio",
        "trabaja_fechafin" => "Fecha fin",
        "fk_horariorotativo_id" => "ID horario rotativo",
        "fk_turno_id" => "ID turno",
        "fk_horariosemanal_id" => "ID horario semanal",
        "fk_empresa_id" => "ID empresa",
        "fk_empleado_id" => "ID empleado",
        "turno_nombre" => "Nombre turno",
        "turno_lunes" => "Lunes",
        "turno_martes" => "Martes",
        "turno_miercoles" => "Miercoles",
        "turno_jueves" => "Jueves",
        "turno_viernes" => "Viernes",
        "turno_sabado" => "Sabado",
        "turno_domingo" => "Domingo",
        "fk_horario_id" => "ID horario",
        "nombre" => "Nombre",
        "estado" => "Estado",
        "observaciones" => "Observaciones",
        "email" => "Email",
        "password" => "Password",
        "created" => "Creado",
        "updated" => "Modificado",
        "deleted" => "Eliminado",
        "empresa_estado" => "Estado empresa"
    );
    function reemplazar($cadena,$excepciones){
        $stringRet = $cadena;
        foreach ($excepciones as $key => $value) {
            $stringRet = preg_replace("/\b$key\b/", $value, $stringRet);
        }
        return $stringRet;
    }
?>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Auditoría / Ver #{{$audit->id}}
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group"><label class="col-lg-2 control-label">Usuario</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">
                                        <a href="{{ route('users.show', $audit->user->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                                {{  $audit->user->nombre }}
                                        </a>
                                    </p>
                                
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Evento</label>
                                <div class="col-lg-10"><p class="form-control-static">{{ trans('generic.'.$audit->event) }} </p></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Valores Viejos</label>
                                <?php
                                    $datos = explode(",", $audit->old_values);
                                    $separado = str_replace($eliminar," ", $datos);
                                    $mostrar = reemplazar($separado,$exceptions) ;
                                ?>
                                    @foreach($mostrar as $value)
                                        @if ($value === reset($mostrar))
                                            <div class="col-lg-10"><p class="form-control-static">{{ $value }} </p></div>
                                        @else
                                            @if ($value === end($mostrar))
                                                <label class="col-lg-2 control-label"></label>
                                                <div class="col-lg-10"><p class="form-control-static">{{ $value }} </p></div>
                                            @else
                                                <label class="col-lg-2 control-label"></label>
                                                <div class="col-lg-10"><p class="form-control-static">{{ $value }} </p></div>
                                            @endif
                                        @endif
                                    @endforeach
                            </div>
                           
                            <div class="form-group"><label class="col-lg-2 control-label">Valores Nuevos</label>
                                <?php
                                    $datos = explode(",", $audit->new_values);
                                    $separado = str_replace($eliminar," ", $datos);
                                    $mostrar = reemplazar($separado,$exceptions) ;
                                ?>
                                    @foreach($mostrar as $value)
                                        @if ($value === reset($mostrar))
                                            <div class="col-lg-10"><p class="form-control-static">{{ $value }} </p></div>
                                        @else
                                            @if ($value === end($mostrar))
                                                <label class="col-lg-2 control-label"></label>
                                                <div class="col-lg-10"><p class="form-control-static">{{ $value }} </p></div>
                                            @else
                                                <label class="col-lg-2 control-label"></label>
                                                <div class="col-lg-10"><p class="form-control-static">{{ $value }} </p></div>
                                            @endif
                                        @endif
                                    @endforeach
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">URL</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $audit->url }} </p></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">IP</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $audit->ip_address }} </p></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Agente</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $audit->user_agent }} </p></div>
                            </div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Fecha</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $audit->updated_at }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('audits.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>


@endsection
