@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    	<title>LLEGADAS TARDES</title>
    	<link rel="stylesheet" href="{{ asset('css/pdf2.css') }}" />
    </head>
    <body>
    	<div id="page-wrap">
    		<textarea id="header">LISTADO DE FALTAS</textarea>
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
                    @elseif(isset($nombres))
                        Empleado {{ $nombres }}
                    @else
                        Todas las oficinas
                    @endif
                </textarea>
    		</div>
    		<div id="meta-box">
    			<table id="meta">
                    <tr>
                        <td class="meta-head">Fecha Inicio</td>
                        <td><textarea id="date">{{ formatFecha($fechaInicio, $format_fecha) }}</textarea></td>
                    </tr>
                    <tr>
                        <td class="meta-head">Fecha Fin</td>
                        <td><textarea id="date">{{ formatFecha($fechaFin, $format_fecha) }}</textarea></td>
                    </tr>
                </table>
    		</div>
    		
    		<table id="items">
    			<tr>
    			    <th>Cedula</th>
                    <th>Empleado</th>
                    <th>Día</th>
    			</tr>
    			@if($registros_ok->count())
                    @foreach($registros_ok as $registro)
                        <tr>
                            <td>{{ $registro[0] }}</td>
                            <td>{{ $registro[1] }}</td>
                            <td>{{ $registro[2] }}</td>
                        </tr>
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