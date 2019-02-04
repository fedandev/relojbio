@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
    $maxExtras = ajuste('max_hours_ext_per_day');
@endphp


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>HORAS EXTRAS</title>
	<link rel="stylesheet" href="{{ asset('css/pdf2.css') }}" />
</head>

<body>

	<div id="page-wrap">
		<textarea id="header">HORAS EXTRAS</textarea>
		
		<div id="identity">
            <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }}
			</textarea>
		</div>
		
		<div id="logo">
            <!--<img id="image" src="{{ public_path('images/'. $logo) }}" alt="logo" class="img-md logo-md"/>-->
        	 <h4 class="logo-name">SGRRHH+</h>
        </div>
		
		<div style="clear:both"></div>
		
		<div id="customer">
            <textarea id="customer-title">
                @if(isset($oficina))
                    Oficina {{ $oficina->oficina_nombre }}
                @else
                    Todas las oficinas
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
		
		<table id="items">
			<tr id="title">
				<th>Empleado</th>
				<th>Cedula</th>
				<th>Fecha</th>
				<th>Horas Extras</th>
			</tr>
			@if($registros->count())
				@php
					$igual = '';
				@endphp
				@foreach($registros as $registro)
					@if($igual != $registro->fk_empleado_cedula)
						@php
							$Empleado = App\Models\Empleado::where('empleado_cedula', $registro->fk_empleado_cedula)->first();
							$horario = horarioAfecha( $Empleado->id, $registro->registro_fecha);
							$horas = totalHorasAfecha($horario);
							
							$aExtras = totalExtras($registros, $horas);
							
							$salida = $horario[1];
							$igual = $registro->fk_empleado_cedula;
						@endphp
						
						@foreach($aExtras as $extra)
							@if($extra[2] <= $maxExtras)
								<tr>
									<td>{{ $Empleado->empleado_nombre }} {{ $Empleado->empleado_apellido }}</td>
									<td>{{ $Empleado->empleado_cedula }}</td>
									<td>{{ $extra[1] }}</td>
									<td>{{ $extra[2] }}</td>
								</tr>
							@endif
					   	@endforeach
					@endif
				@endforeach
			@else
				<tr>
					<td colspan="6">
						<h3 class="text-center alert alert-info">No hay datos para mostrar!</h3>
					</td>
				</tr>    
			@endif
		</table>
	</div>
</body>
</html>