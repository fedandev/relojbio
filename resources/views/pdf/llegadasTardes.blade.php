
@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
    $empleado_header =  ($registros_ok->count() > 0 ? App\Models\Empleado::where('empleado_cedula',$registros_ok[0]['fk_empleado_cedula'] )->first() : '');
    $SeparoEmpleados = ajuste('hoja_por_empleado');
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
                <th>Empleado</th>
                <th>Hora Entrada</th>
                <th>Fin Brake</th>
                <th>Fecha/Hora</th>
                <th>Diferencia</th>
			</tr>
			@if($registros_ok->count())
			    @php
	                $i=0;
	            @endphp
	            @foreach($registros_ok as $registro)
	                    <?php $i++; ?>
	                    @if ($i == 29 )
                         
                            @php
    			                $i=0;
    			                echo '</table>';
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
                                <th>Empleado</th>
                                <th>Hora Entrada</th>
                                <th>Fin Brake</th>
                                <th>Fecha/Hora</th>
                                <th>Diferencia</th>
                			</tr>
                        @endif
                        <tr>
                            <td>{{ $registro['empleado'] }}</td>
                            <td>{{ $registro['hora_entrada'] }}</td>
                            <td>{{ $registro['fin_brake'] }}</td>
                            <td>{{ $registro['registro_fecha']  }}</td>
                            <td>{{  $registro['diferencia']  }}</td>
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

