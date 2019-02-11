
@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
    $empleado_header =  ($registros_ok->count() > 0 ? $registros_ok[0]->empleado : ''); 
    
@endphp


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>LLEGADAS TARDES</title>
	<link rel="stylesheet" href="{{ asset('css/pdf2.css') }}" />
</head>


<body>

	<div id="page-wrap" >
       
        <textarea id="header">LLEGADAS TARDES</textarea>
    	@include('pdf.cabecera')	
    	
		<table id="items" >
			<tr>
				<th>ID</th>
                <th>Empleado</th>
                <th>Hora Entrada</th>
                <th>Entrada/Salida</th>
                <th>Fecha/Hora</th>
                <th>Diferencia</th>
			</tr>
			@if($registros_ok->count())
			    @php
	                $i=0;
	                $first_cedula = $registros_ok[0]->empleado->empleado_cedula;
	               
	            @endphp
	            @foreach($registros_ok as $registro)
	                    <?php $i++; ?>
	                    @if ($i == 29 || $registro->empleado->empleado_cedula <> $first_cedula)
                         
                            @php
    			                $i=0;
    			                echo '</table>';
    			                $first_cedula = $registro->empleado->empleado_cedula;
    			                $empleado_header = $registro->empleado;
    			            @endphp
            			     
                            <div id="footer">
                              <div class="page-number"></div>
                            </div>
    			            <div style="page-break-after:always;"></div>
    			            <textarea id="header">LLEGADAS TARDES</textarea>
    	                    @include('pdf.cabecera')
    			            @php
    			                echo '<table id="items" >'
    			            @endphp
            			     
    			            <tr>
                				<th>ID</th>
                                <th>Empleado</th>
                                <th>Hora Entrada</th>
                                <th>Entrada/Salida</th>
                                <th>Fecha/Hora</th>
                                <th>Diferencia</th>
                			</tr>
                        @endif
                        <tr>
                            <td>{{ $registro->id }}</td>
                            <td>{{ $registro->empleado->empleado_cedula }} - {{ $registro->empleado->empleado_nombre }} {{ $registro->empleado->empleado_apellido }}</td>
                            @php
                                $horario = horarioAfecha($registro->empleado->id, $registro->registro_fecha);
                                $entrada = $horario[0];
                            @endphp
                            <td>{{ $entrada }}</td>
                            <td>
                                @if ($registro->registro_tipo == "I")
                                    Entrada
                                @else
                                    Salida
                                @endif
                            </td>
                            <td>{{ $registro->registro_hora }}</td>
                            <td>{{  date('H:i:s', strtotime($registro->registro_hora) - strtotime($entrada)) }}</td>
                           
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
		<div id="footer">
          <div class="page-number"></div>
        </div>		
	</div>
	
</body>

</html>

