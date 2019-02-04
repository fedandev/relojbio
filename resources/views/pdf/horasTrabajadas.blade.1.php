@php
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
@endphp


<link rel="stylesheet" href="{{ asset('css/pdf.css') }}" />

<table width="100%">
    <tr>
        <td width="200" valign="bottom" style="padding-bottom:25px" >{{ $empresa }}<br>
            {{ formatFecha($now, $format_fh) }}
        </td>
        <td align="center"><h1>Reporte de Horas Trabajadas</h1></td>
        <td width="200" align="right"><img src="{{ public_path('images/'. $logo) }}" height="124" width="124"> </td>
        
    </tr>
    <tr>
        <td valign="top"  height="20px" colspan="3">
            <i>
                
            </i>
        </td>
    </tr>
    <tr class="border_bottom">
        <td colspan="2" bordercolor="#000000">
            <pre><p>Empleado:     {{ $empleado[0]->empleado_nombre }} {{ $empleado[0]->empleado_apellido }}</p></pre>
            <pre><p>Cedula:       {{ $empleado[0]->empleado_cedula }}</p></pre>
            <pre><p>Fecha Inicio: {{ formatFecha($fechainicio, $format_fecha) }}</p></pre>
            <pre><p>Fecha Fin:    {{ formatFecha($fechafin, $format_fecha) }}</p></pre>
            <pre><p>Total Horas:  {{ $suma[0]->registro_sumaHoras }}</p></pre>
      	</td>
      	<td>
          <div class="cuadrado" style="background: #FFB500; float:left; "></div><div style="float:left; margin-left:5px;">Falta Justificada</div><br>
          <div class="cuadrado" style="background: #62FF00; float:left;"></div><div style="float:left; margin-left:5px;">Manual</div><br>
          <div class="cuadrado" style="background: #00FFD1; float:left;"></div><div style="float:left; margin-left:5px;">Licencia </div><br>
          <div class="cuadrado" style="background: #00ACFF; float:left;"></div><div style="float:left; margin-left:5px;">Medica </div>
      	</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
</table>

<table class="registros" width="100%">
    <thead>
        <tr class="cabezera">
            <th>Fecha</th>
            <th>Hora Entrada</th>
            <th>Hora Salida</th>
            <th>Total Horas</th>
        </tr>                            
    </thead>
    <tbody>
        @if($registros->count())
            @foreach($registros as $registro)
                @foreach($tiposRegistros as $tipoRegistro)
                    @if($registro->registro_tipoEntrada == $tipoRegistro['Nombre'])    
                        <tr style="background-color: {{ $tipoRegistro['Color'] }}">
                            <td>{{ formatFecha($registro->registro_fecha, $format_fecha) }}</td>    
                            <td>{{ formatHora($registro->registro_entrada, $format_hora)  }}</td>
                            <td>{{ formatHora($registro->registro_salida, $format_hora)   }}</td>
                            <td>{{ $registro->registro_totalHoras }}</td>
                        </tr>
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
    </tbody>
</table>