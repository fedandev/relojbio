@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    use App\SumaTiempos;
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
    $maxExtras = ajuste('max_hours_ext_per_day');
    $SeparoEmpleados = ajuste('hoja_por_empleado');
	$totalHoras = 0;
	$tiempoTrabajado = new SumaTiempos();
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
            @include('pdf.cabecera')	
            <table id="items">
                <tr id="title">
                    <th>Empleado</th>
                    <th>Cedula</th>
                    <th>Fecha</th>
                    <th>Horas a Trabajar</th>
                    <th>Horas Trabajadas</th>
                    <th>Horas Extras</th>
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
                                echo '<tr>';
                                echo 	'<td colspan="4"></td>';
                                echo	'<td>Total de Horas</td>';
                                echo	'<td>'. $tiempoTrabajado->verTiempoFinal() .'</td>';
                                echo '</tr>';
                                echo '</table>';
                                $tiempoTrabajado = new SumaTiempos();
                            @endphp

                            <div id="footer">
                              <div class="page-number"></div>
                            </div>
                            <div style="page-break-after:always;"></div>
                            <textarea id="header">HORAS EXTRAS</textarea>
                            @include('pdf.cabecera')
                            @php
                                echo '<table id="items" >'
                            @endphp

                            <tr id="title">
                                <th>Empleado</th>
                                <th>Cedula</th>
                                <th>Fecha</th>
                                <th>Horas a Trabajar</th>
                                <th>Horas Trabajadas</th>
                                <th>Horas Extras</th>
                            </tr>
                        @endif
                        @if($loop->last)
                            <tr>
                                <td>{{ $registro['empleado'] }}</td>
                                <td>{{ $registro['fk_empleado_cedula'] }}</td>
                                <td>{{ $registro['registro_fecha'] }}</td>
                                <td>{{ $registro['horas_debe_trabajar'] }}</td>
                                <td>{{ $registro['horas_trabajadas'] }}</td>
                                <td>{{ $registro['horas_extras'] }}</td>
                            </tr>
                            @php
                                $tiempoTrabajado->sumaTiempo(new SumaTiempos($registro['horas_extras']));
                            @endphpp
                            <tr>
                                <td colspan="4"></td>
                                <td>Total de Horas</td>
                                <td>{{ $tiempoTrabajado->verTiempoFinal() }}</td>
                            </tr>
                            @php
                                $totalHoras = 0;
                            @endphp
                        @else
                            <tr>
                                <td>{{ $registro['empleado'] }}</td>
                                <td>{{ $registro['fk_empleado_cedula'] }}</td>
                                <td>{{ $registro['registro_fecha'] }}</td>
                                <td>{{ $registro['horas_debe_trabajar'] }}</td>
                                <td>{{ $registro['horas_trabajadas'] }}</td>
                                <td>{{ $registro['horas_extras'] }}</td>
                            </tr>
                            @php
                                $tiempoTrabajado->sumaTiempo(new SumaTiempos($registro['horas_extras']));
                            @endphp
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