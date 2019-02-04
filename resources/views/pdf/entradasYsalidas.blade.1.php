<?php
$logo = App\Models\Ajuste::where('ajuste_nombre', 'system_logo')->first();
$empresa = App\Models\Ajuste::where('ajuste_nombre', 'company_name')->first();
$hora = App\Models\Ajuste::where('ajuste_nombre', 'time_format')->first();
?>
<link rel="stylesheet" href="{{ asset('css/pdf.css') }}" />

<table width="100%">
    <tr>
        <td width="200" valign="bottom" style="padding-bottom:25px" >{{ $empresa->ajuste_valor }}<br>
            @php
                $now = new \DateTime();
                echo $now->format($formatoFecha->ajuste_valor." ". $hora->ajuste_valor);
            @endphp
        </td>
        <td align="center"><h1>Reporte de Entradas y Salidas</h1></td>
        <td width="200" align="right"><img src="{{ public_path('images/'. $logo->ajuste_valor) }}" height="124" width="124"> </td>
    </tr>
    <tr>
        <td valign="top"  height="20px" colspan="3">
            <i>
                
            </i>
        </td>
    </tr>
    <tr class="border_bottom">
        <td colspan="3" bordercolor="#000000">
            <pre><p>Empleado:     {{ $empleado[0]->empleado_nombre }} {{ $empleado[0]->empleado_apellido }}</p></pre>
            <pre><p>Cedula:       {{ $empleado[0]->empleado_cedula }}</p></pre>
            <pre><p>Fecha Inicio: {{ \Carbon\Carbon::parse($fechainicio)->format($formatoFecha->ajuste_valor) }}</p></pre>
            <pre><p>Fecha Fin:    {{ \Carbon\Carbon::parse($fechafin)->format($formatoFecha->ajuste_valor) }}</p></pre>
      	</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
</table>

<table class="registros" width="100%">
    <thead>
        <tr class="cabezera">
            <th>ID</th>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Entrada/Salida</th>
            <th>Fecha/Hora</th>
        </tr>                            
    </thead>
    <tbody>
        @if($registros->count())
            @foreach($registros as $registro)
            <tr>
                <td>{{ $registro->id }}</td>
                <td>{{ $registro->empleado->empleado_cedula }}</td>
                <td>{{ $registro->empleado->empleado_nombre }}</td>
                <td>{{ $registro->empleado->empleado_apellido }}</td>
                <td>
                    @if ($registro->registro_tipo == "I")
                        Entrada
                    @else
                        Salida
                    @endif
                </td>
                <td>{{ $registro->registro_hora }}</td>
            </tr>
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