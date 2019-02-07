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
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>HORAS NOCTURNAS</title>
	<link rel="stylesheet" href="{{ asset('css/pdf2.css') }}" />
</head>
<body>
	<div id="page-wrap">
		<textarea id="header">HORAS NOCTURNAS</textarea>
		<div id="identity">
            <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }}
			</textarea>
		</div>
		
		<div id="logo">
            <img id="image" src="{{ public_path('images/'. $logo) }}" alt="logo" class="img-md logo-md"/>
        </div>
		
		<div style="clear:both"></div>
		
		<div id="customer">
            <textarea id="customer-title">
                @if(isset($oficina))
                    Oficina {{ $oficina->oficina_nombre }}
                @elseif($empleados>1)
                    Todas las oficinas
                @else
                    Empleado: {{ $empleado->empleado_nombre }} {{ $empleado->empleado_apellido }}
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
			<tr>
			    <th>Empleado</th>
				<th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Total Horas</th>
			</tr>
			@if($registros->count())
			    @foreach($registros->groupBy('fk_empleado_cedula') as $registro_group)
		            @if($loop->last)
		                @php
		                    $ultimo='S';
		                @endphp
		            @endif
		            @foreach($registro_group as $registro)
		                @if($loop->last)
			                @php
    			                $i=1;
    			            @endphp
			                <tr>
                                @php
            					    $Empleado = App\Models\Empleado::where('empleado_cedula', $registro->fk_empleado_cedula)->first();
                                @endphp
                                <td>{{ $Empleado->empleado_cedula }} - {{ $Empleado->empleado_nombre }} {{ $Empleado->empleado_apellido }}</td>
                                <td>{{ formatFecha($registro->registro_fecha, $format_fecha)  }}</td>    
                                <td>{{ formatHora($registro->registro_entrada, $format_hora)  }}</td>
                                <td>{{ formatHora($registro->registro_salida, $format_hora)   }}</td>
                                <td>{{ $registro->registro_totalHoras }}</td>
                            </tr>
                            @if($ultimo != 'S')
                                <div id="footer">
                                  <div class="page-number"></div>
                                </div>
                                <div style="page-break-after:always;"></div>
                                </table>
                                <textarea id="header">HORAS NOCTURNAS</textarea>
                        		<div id="identity">
                                    <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }}
                        			</textarea>
                        		</div>
                        		
                        		<div id="logo">
                                    <img id="image" src="{{ public_path('images/'. $logo) }}" alt="logo" class="img-md logo-md"/>
                                </div>
                        		
                        		<div style="clear:both"></div>
                        		
                        		<div id="customer">
                                    <textarea id="customer-title">
                                        @if(isset($oficina))
                                            Oficina {{ $oficina->oficina_nombre }}
                                        @elseif($empleados>1)
                                            Todas las oficinas
                                        @else
                                            Empleado: {{ $empleado->empleado_nombre }} {{ $empleado->empleado_apellido }}
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
                        			<tr>
                        			    <th>Empleado</th>
                        				<th>Fecha</th>
                                        <th>Hora Entrada</th>
                                        <th>Hora Salida</th>
                                        <th>Total Horas</th>
                        			</tr>
                            @endif 
        			    @else
			                @php
    			                $i += 1;
    			            @endphp
    			            @if($i <= 29)
    			                <tr>
                                    @php
                					    $Empleado = App\Models\Empleado::where('empleado_cedula', $registro->fk_empleado_cedula)->first();
                                    @endphp
                                    <td>{{ $Empleado->empleado_cedula }} - {{ $Empleado->empleado_nombre }} {{ $Empleado->empleado_apellido }}</td>
                                    <td>{{ formatFecha($registro->registro_fecha, $format_fecha)  }}</td>    
                                    <td>{{ formatHora($registro->registro_entrada, $format_hora)  }}</td>
                                    <td>{{ formatHora($registro->registro_salida, $format_hora)   }}</td>
                                    <td>{{ $registro->registro_totalHoras }}</td>
                                </tr>
                            @else
                    		    @php
        			                $i=1;
        			            @endphp
        			            <div id="footer">
                                  <div class="page-number"></div>
                                </div>
        			            <div style="page-break-after:always;"></div>
                                </table>
                                <textarea id="header">HORAS NOCTURNAS</textarea>
                        		<div id="identity">
                                    <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }}
                        			</textarea>
                        		</div>
                        		
                        		<div id="logo">
                                    <img id="image" src="{{ public_path('images/'. $logo) }}" alt="logo" class="img-md logo-md"/>
                                </div>
                        		
                        		<div style="clear:both"></div>
                        		
                        		<div id="customer">
                                    <textarea id="customer-title">
                                        @if(isset($oficina))
                                            Oficina {{ $oficina->oficina_nombre }}
                                        @elseif($empleados>1)
                                            Todas las oficinas
                                        @else
                                            Empleado: {{ $empleado->empleado_nombre }} {{ $empleado->empleado_apellido }}
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
                        			<tr>
                        			    <th>Empleado</th>
                        				<th>Fecha</th>
                                        <th>Hora Entrada</th>
                                        <th>Hora Salida</th>
                                        <th>Total Horas</th>
                        			</tr>
                    		@endif
    			        @endif
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
				
	</div>
	
</body>

</html>
