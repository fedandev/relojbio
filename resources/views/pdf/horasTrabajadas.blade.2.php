@php
    use App\SumaTiempos;
    // La funcion ajuste y formatFecha estan en el archivo app/http/helper.php
    $logo = ajuste('system_logo');
    $empresa = ajuste('company_name');
    $format_hora =ajuste('time_format');
    $format_fecha=ajuste('date_format');
    $format_fh = $format_fecha. " " .$format_hora;
    $now = date("D M d, Y G:i");
    $ultimo ='N';
    $i = 0;
    $tiempoTrabajado = new SumaTiempos();
    $SeparoEmpleados = ajuste('hoja_por_empleado');
    $maxHorasXdias = ajuste('max_hours_per_day');
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>HORAS TRABAJADAS</title>
	<link rel="stylesheet" href="{{ asset('css/pdf2.css') }}" />
</head>
<body>
	<div id="page-wrap">
		<textarea id="header">HORAS TRABAJADAS</textarea>
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
                @elseif(count($empleados)>1)
                    Todas las oficinas
                @else
                    Empleado: {{ $empleados[0]->empleado_nombre }} {{ $empleados[0]->empleado_apellido }}
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
		
		<table id="items">
			<tr>
			    <th>Empleado</th>
				<th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Total Horas</th>
			</tr>
			@if($registros->count())
			    @foreach($registros->groupBy('fk_empleado_cedula') as $registro_group)
		            @if($loop->last)
		                @php
		                    $ultimo='S';
		                @endphp
		            @endif
		            @foreach($registro_group->sortBy('registro_fecha') as $registro)
		                @if($loop->last)
        			        @foreach($empleados as $empleado)
        			            @if($empleado->empleado_cedula == $registro->fk_empleado_cedula)
            			                @if($i <= 29)
                    			            @php
                    			                $i += 2;
                    			            @endphp
                			                <tr>
                                                <td>{{ $empleado->empleado_nombre }} {{ $empleado->empleado_apellido }}</td>
                                                <td>{{ formatFecha($registro->registro_fecha, $format_fecha) }}</td>    
                                                <td>{{ formatHora($registro->registro_entrada, $format_hora)  }}</td>
                                                <td>{{ formatHora($registro->registro_salida, $format_hora)   }}</td>
                                                @if($registro->registro_totalHoras > $maxHorasXdias)
                            					    <td style="background-color: rgba(255, 0, 0, 0.2)">{{ $registro->registro_totalHoras }}</td>
                            					@else
                            					    <td>{{ $registro->registro_totalHoras }}</td>
                            					@endif
                                            </tr>
                                            @if($registro->registro_totalHoras != null)
                                                @php
                        							$tiempoTrabajado->sumaTiempo(new SumaTiempos($registro->registro_totalHoras));
                        						@endphp
                        					@endif
                        					    <tr style="background-color: rgba(128, 128, 128, 0.2)">
                    							<td colspan="3"></td>
                    							<td>Total de Horas</td>
                    							<td>{{ $tiempoTrabajado->verTiempoFinal() }}</td>
                    						</tr>
                    						@php
                    							$tiempoTrabajado = new SumaTiempos();
                    						@endphp
                                        @else
                                		    @php
                    			                $i=1;
                    			            @endphp
                    			            <div id="footer">
                                              <div class="page-number"></div>
                                            </div>
                    			            <div style="page-break-after:always;"></div>
                                            </table>
                                            <textarea id="header">HORAS TRABAJADAS</textarea>
                                            
                                    		<div id="identity">
                                                <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }}
                                    			</textarea>
                                    		</div>
                                    		
                                    		<div id="logo">
                                                <img id="image" src="{{ public_path('images/'. $logo) }}" alt="logo" class="img-md logo-md"/>
                                                 
                                            </div>
                                    		
                                    		<div style="clear:both"></div>
                                    		
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
                                    		
                                            <table id="items">
                                    			<tr>
                                    			    <th>Empleado</th>
                                    				<th>Fecha</th>
                                                    <th>Hora Entrada</th>
                                                    <th>Hora Salida</th>
                                                    <th>Total Horas</th>
                                    			</tr>
                                    			<tr>
                                                    <td>{{ $empleado->empleado_nombre }} {{ $empleado->empleado_apellido }}</td>
                                                    <td>{{ formatFecha($registro->registro_fecha, $format_fecha) }}</td>    
                                                    <td>{{ formatHora($registro->registro_entrada, $format_hora)  }}</td>
                                                    <td>{{ formatHora($registro->registro_salida, $format_hora)   }}</td>
                                                    @if($registro->registro_totalHoras >= $maxHorasXdias)
                                					    <td style="background-color: rgba(255, 0, 0, 0.2)">{{ $registro->registro_totalHoras }}</td>
                                					@else
                                					    <td>{{ $registro->registro_totalHoras }}</td>
                                					@endif
                                                </tr>
                                                @if($registro->registro_totalHoras != null)
                                                    @php
                            							$tiempoTrabajado->sumaTiempo(new SumaTiempos($registro->registro_totalHoras));
                            						@endphp
                            					@endif
                                		@endif
                                        @if($ultimo != 'S')
                                            @if($SeparoEmpleados == 'S')
                        						@php
                        							$tiempoTrabajado = new SumaTiempos();
                        						@endphp
                                                <div id="footer">
                                                  <div class="page-number"></div>
                                                </div>
                                                <div style="page-break-after:always;"></div>
                                                </table>
                                                <textarea id="header">HORAS TRABAJADAS</textarea>
                                                
                                        		<div id="identity">
                                                    <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }}
                                        			</textarea>
                                        		</div>
                                        		
                                        		<div id="logo">
                                                    <img id="image" src="{{ public_path('images/'. $logo) }}" alt="logo" class="img-md logo-md"/>
                                                     
                                                </div>
                                        		
                                        		<div style="clear:both"></div>
                                        		
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
                                        		
                                                <table id="items">
                                        			<tr>
                                        			    <th>Empleado</th>
                                        				<th>Fecha</th>
                                                        <th>Hora Entrada</th>
                                                        <th>Hora Salida</th>
                                                        <th>Total Horas</th>
                                        			</tr>
                                        	@endif
                                        @endif
        			            @endif
        			        @endforeach
        			    @else
        			        @foreach($empleados as $empleado)
        			            @if($empleado->empleado_cedula == $registro->fk_empleado_cedula)
        			                @php
            			                $i += 1;
            			            @endphp
            			            @if($i < 29)
            			                <tr>
                                            <td>{{ $empleado->empleado_nombre }} {{ $empleado->empleado_apellido }}</td>
                                            <td>{{ formatFecha($registro->registro_fecha, $format_fecha) }}</td>    
                                            <td>{{ formatHora($registro->registro_entrada, $format_hora)  }}</td>
                                            <td>{{ formatHora($registro->registro_salida, $format_hora)   }}</td>
                                            @if($registro->registro_totalHoras >= $maxHorasXdias)
                        					    <td style="background-color: rgba(255, 0, 0, 0.2)">{{ $registro->registro_totalHoras }}</td>
                        					@else
                        					    <td>{{ $registro->registro_totalHoras }}</td>
                        					@endif
                                        </tr>
                                        @if($registro->registro_totalHoras != null)
                                            @php
                    							$tiempoTrabajado->sumaTiempo(new SumaTiempos($registro->registro_totalHoras));
                    						@endphp
                    					@endif
                                    @else
                            		    @php
                			                $i=1;
                			            @endphp
                			            <div id="footer">
                                          <div class="page-number"></div>
                                        </div>
                			            <div style="page-break-after:always;"></div>
                                        </table>
                                        <textarea id="header">HORAS TRABAJADAS</textarea>
                                        
                                		<div id="identity">
                                            <textarea id="address">{{ $empresa }}<br>{{ formatFecha($now, $format_fh) }}
                                			</textarea>
                                		</div>
                                		
                                		<div id="logo">
                                            <img id="image" src="{{ public_path('images/'. $logo) }}" alt="logo" class="img-md logo-md"/>
                                             
                                        </div>
                                		
                                		<div style="clear:both"></div>
                                		
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
                                		
                                        <table id="items">
                                			<tr>
                                			    <th>Empleado</th>
                                				<th>Fecha</th>
                                                <th>Hora Entrada</th>
                                                <th>Hora Salida</th>
                                                <th>Total Horas</th>
                                			</tr>
                                    			<tr>
                                                <td>{{ $empleado->empleado_nombre }} {{ $empleado->empleado_apellido }}</td>
                                                <td>{{ formatFecha($registro->registro_fecha, $format_fecha) }}</td>    
                                                <td>{{ formatHora($registro->registro_entrada, $format_hora)  }}</td>
                                                <td>{{ formatHora($registro->registro_salida, $format_hora)   }}</td>
                                                @if($registro->registro_totalHoras >= $maxHorasXdias)
                            					    <td style="background-color: rgba(255, 0, 0, 0.2)">{{ $registro->registro_totalHoras }}</td>
                            					@else
                            					    <td>{{ $registro->registro_totalHoras }}</td>
                            					@endif
                                            </tr>
                                            @if($registro->registro_totalHoras != null)
                                                @php
                        							$tiempoTrabajado->sumaTiempo(new SumaTiempos($registro->registro_totalHoras));
                        						@endphp
                        					@endif
                            		@endif
        			            @endif
        			        @endforeach
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
		</table>
	</div>
	
</body>
</html>

