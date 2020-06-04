@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    use App\SumaTiempos;
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
        <title>REPORTE DE MARCAS EN EL DIA DE AYER</title>
        <link rel="stylesheet" href="{{ public_path().'/css/pdf2.css' }}" />
    </head>
    <body>
        <div id="page-wrap">
            <textarea id="header" >REPORTE DE MARCAS EN EL DIA DE AYER</textarea>
            @include('pdf.cabecera')
            <table id="items">
                <tr id="title">
                    <th>Empleado</th>
                    <th>Cedula</th>
                    <th>Fecha</th>
                    <th>Horas a Trabajar</th>
                    <th>Horas Marcadas</th>
                    <th>Horas Extras</th>
                    <th>Horas Faltan Marcar</th>
                </tr>
                @if($registros_ok->count())
                    @php
                        $i=0;
                    @endphp
                    @foreach($registros_ok as $registro)
                        <?php $i++; ?>
                        @if ($i == 24 )    
                            @php
                                echo '</table>';
                            @endphp
                            <div id="footer">
                                <div class="page-number"></div>
                            </div>
                            <div style="page-break-after:always;"></div>
                            <textarea id="header">REPORTE DE MARCAS EN EL DIA DE AYER</textarea>
                            @include('pdf.cabecera')
                            @php
                                echo '<table id="items" >'
                            @endphp
                            <tr id="title">
                                <th>Empleado</th>
                                <th>Cedula</th>
                                <th>Fecha</th>
                                <th>Horas a Trabajar</th>
                                <th>Horas Marcadas</th>
                                <th>Horas Extras</th>
                                <th>Horas Faltan Marcar</th>
                            </tr>
                        @endif
                        <tr>
                            <td>{{ $registro['empleado'] }}</td>
                            <td>{{ $registro['fk_empleado_cedula'] }}</td>
                            <td>{{ $registro['registro_fecha'] }}</td>
                            <td>{{ $registro['horas_debe_trabajar'] }}</td>
                            <td>{{ $registro['horas_trabajadas'] }}</td>
                            <td>{{ $registro['horas_extras'] }}</td>
                            <td>{{ $registro['horas_diff'] }}</td>
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