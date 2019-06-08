@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
    $SeparoEmpleados = ajuste('hoja_por_empleado');
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>SALIDAS ANTES DE HORA</title>
	<link rel="stylesheet" href="{{ asset('css/pdf2.css') }}" />
</head>


<body>

	<div id="page-wrap">
        @section('header')
    		<textarea id="header">SALIDAS ANTES DE HORA</textarea>
    		
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
    	@endsection
		
		@yield('header')
		
		<table id="items">
			<tr>
                <th>Empleado</th>
                <th>Inicio brake</th>
                <th>Fin brake</th>
                <th>Horario Salida</th>
                <th>Fecha/Hora</th>
			</tr>
			@if($registros_ok->count())
			    @php
	                $i=0;
	            @endphp
                @foreach($registros_ok as $registro)
                <?php $i++ ?>
                <tr>
                    <td>{{ $registro['empleado'] }}</td>
                    @if($registro['inicio_brake'] != null){
                        <td>{{ $registro['inicio_brake']  }}</td>
                    @else
                        <td>No Tiene</td>
                    @endif
                    @if($registro['fin_brake'] != null){
                        <td>{{ $registro['fin_brake']  }}</td>
                    @else
                        <td>No Tiene</td>
                    @endif
                    <td>{{ $registro['hora_salida'] }}</td>
                    <td>{{ $registro['registro_fecha']  }}</td>
                </tr>
                    @if ($i == 29)
                     
                        @php
			                $i=0;
			                echo '</table>';
			            @endphp
        			     
                        <div id="footer">
                          <div class="page-number"></div>
                        </div>
			            <div style="page-break-after:always;"></div>
			            @yield('header')
			            @php
			                echo '<table id="items" >'
			            @endphp
        			     
			            <tr>
            			    <th>Empleado</th>
            			    <th>Inicio brake</th>
            			    <th>Fin brake</th>
                            <th>Horario Salida</th>
                            <th>Fecha/Hora</th>
            			</tr>
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
		<div id="footer">
          <div class="page-number"></div>
        </div>			
	</div>
	
</body>

</html>
