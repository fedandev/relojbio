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
        @else
            Empleado: {{ $empleado_header->empleado_nombre }} {{ $empleado_header->empleado_apellido }}
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