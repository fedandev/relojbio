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
        <title>DOCUMENTOS POR VENCER</title>
        <link rel="stylesheet" href="{{ public_path().'/css/pdf2.css' }}" />
    </head>
    <body>
        <div id="page-wrap">
            <textarea id="header" >DOCUMENTOS POR VENCER</textarea>
            <div id="identity">    		
                <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }} </textarea>
            </div>

            <div id="logo">
                <img id="image" src="{{ public_path().'/images/'. $logo }}" alt="logo" class="img-md logo-md"/>
            </div>

            <div style="clear:both"></div>

            <div id="customer">
                <textarea id="customer-title">                    
                </textarea>
            </div>

            <div id="meta-box">
              <table id="meta">
                    <tr>
                        <td class="meta-head">Fecha</td>
                        <td><textarea id="date">{{ formatFecha($hoy, $format_fecha) }}</textarea></td>
                    </tr>                    
                </table>
            </div>
            <table id="items">
                <tr id="title">
                    <th>Empleado</th>
                    <th>Cedula</th>
                    <th>Fecha Venc. Cedula</th>
                    <th>Fecha Venc. Licencia Conducir</th>
                    <th>Fecha Venc. Carne Salud</th>
                    <th>Vence Cedula?</th>
                    <th>Vence Licencia Conducir?</th>    
                    <th>Vence Carne Salud?</th>   
                </tr>
                @if($arrayEmpleados->count())
                    @php
                        $i=0;
                    @endphp
                    @foreach($arrayEmpleados as $empleado)
                        <?php $i++; ?>
                        @if ($i == 24 )    
                            @php
                                echo '</table>';
                            @endphp
                            <div id="footer">
                                <div class="page-number"></div>
                            </div>
                            <div style="page-break-after:always;"></div>
                            <textarea id="header">DOCUMENTOS POR VENCER</textarea>
                            <div id="identity">    		
                                <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }} </textarea>
                            </div>

                            <div id="logo">
                                <img id="image" src="{{ public_path().'/images/'. $logo }}" alt="logo" class="img-md logo-md"/>
                            </div>

                            <div style="clear:both"></div>

                            <div id="customer">
                                <textarea id="customer-title">                    
                                </textarea>
                            </div>

                            <div id="meta-box">
                              <table id="meta">
                                    <tr>
                                        <td class="meta-head">Fecha</td>
                                        <td><textarea id="date">{{ formatFecha($hoy, $format_fecha) }}</textarea></td>
                                    </tr>                    
                                </table>
                            </div>
                            @php
                                echo '<table id="items" >'
                            @endphp
                            <tr id="title">
                                <th>Empleado</th>
                                <th>Cedula</th>
                                <th>Fecha Venc. Cedula</th>
                                <th>Fecha Venc. Licencia Conducir</th>
                                <th>Fecha Venc. Carne Salud</th>
                                <th>Vence Cedula?</th>
                                <th>Vence Licencia Conducir?</th>  
                                <th>Vence Carne Salud?</th> 
                            </tr>
                        @endif
                        <tr>
                            <td>{{ $empleado['nombre'] }}</td>
                            <td>{{ $empleado['cedula'] }}</td>
                            <td>{{ $empleado['fec_venc_ced'] }}</td>
                            <td>{{ $empleado['fec_venc_lic'] }}</td>
                            <td>{{ $empleado['fec_venc_sal'] }}</td>
                            <td>@if($empleado['venc_ced'] == 'S') SI @else NO @endif</td>
                            <td>@if($empleado['venc_lic'] == 'S') SI @else NO @endif</td>       
                            <td>@if($empleado['venc_sal'] == 'S') SI @else NO @endif</td> 
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