@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
    $ultimo ='N';
    $i = 0;
    $SeparoEmpleados = ajuste('hoja_por_empleado');
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <title>ENTRADAS Y SALIDAS</title>
        <link rel="stylesheet" href="{{ asset('css/pdf3.css') }}" />
    </head>
    <body>
        <div id="header2">
            <textarea id="header">ENTRADAS Y SALIDAS</textarea>
            <div id="identity">
                <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }}
                </textarea>
            </div>
            <div id="logo">
                <img id="image" src="{{ asset('images/'. $logo) }}" alt="logo" class="img-md logo-md"/>
            </div>
            <div style="clear:both"></div>
            <div id="customer">
                <textarea id="customer-title">
                    @if(isset($oficina))
                        Oficina {{ $oficina->oficina_nombre }}
                    @elseif(count($empleados)>1)
                        Todas las oficinas
                    @else
                        Empleado: {{ $empleados[0]->empleado_nombre }} {{ $empleados[0]->empleado_apellido }}
                    @endif
                </textarea>
            </div>
            <div id="meta-box">
                <table id="meta">
                    <tr>
                        <td class="meta-head">Fecha Inicio</td>
                        <td><textarea id="date">{{ formatFecha($fechainicio, $format_fecha) }}</textarea></td>
                    </tr>
                    <tr>
                        <td class="meta-head">Fecha Fin</td>
                        <td><textarea id="date">{{ formatFecha($fechafin, $format_fecha) }}</textarea></td>
                    </tr>
                </table>
            </div>
        </div>
		<table id="items">
			<tr>
				<th>ID</th>
                <th>Cedula</th>
                <th>Nombre/Apellido</th>
                <th>Entrada/Salida</th>
                <th>Fecha</th>
                <th>Hora</th>
			</tr>
			@if($registros->count())
                @php
                    $i=1;
                @endphp
			    @foreach($registros->groupBy('fk_empleado_cedula') as $registro_group)
		            @foreach($registro_group as $registro)
                        @foreach($empleados as $empleado)
                            @if($empleado->empleado_cedula == $registro->fk_empleado_cedula)
                                @php
                                    $i++;
                                @endphp
                                @if($i > 29)
                                    <tr>
                                        <th>ID</th>
                                        <th>Cedula</th>
                                        <th>Nombre/Apellido</th>
                                        <th>Entrada/Salida</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                    </tr>
                                    @php
                                        $i=2;
                                    @endphp
                                @endif
                                @if($registro->registro_tipo == "I")
                                    <tr style="background-color: rgba(128, 128, 128, 0.2)">
                                @else
                                    <tr style="background-color: rgba(128, 128, 128, 0.7)">
                                @endif
                                    <td>{{ $registro->id }}</td>
                                    <td>{{ $registro->empleado->empleado_cedula }}</td>
                                    <td>{{ $registro->empleado->empleado_nombre }} {{ $registro->empleado->empleado_apellido }}</td>
                                    <td>
                                        @if ($registro->registro_tipo == "I")
                                            Entrada
                                        @else
                                            Salida
                                        @endif
                                    </td>
                                    <td>{{ formatFecha($registro->registro_fecha, $format_fecha) }}</td>
                                    <td>{{ formatHora($registro->registro_hora, $format_hora) }}</td>
                                </tr>
                            @endif
                        @endforeach
    			    @endforeach
			    @endforeach
            @else
            <tr>
                <td colspan="6">
                    <h3 class="text-center alert alert-info">No hay datos para mostrar!</h3>
                </td>
            </tr>    
            @endif
		</table>
    </body>
</html>