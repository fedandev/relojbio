@extends('layouts.app')

@section('content')
<?php use App\Http\Controllers\LicenciasController ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Lista de licencias cargadas</h5>
                </div>
				
				<div class="ibox-content">
				    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('licencias.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
				    
					<div class="table-responsive">
                    
					    @if($licencias->count())
    						<table class="footable table table-stripped toggle-arrow-tiny" data-filter=#filter data-page="true">
    							<thead>
                                    <tr>
                                        <th data-toggle="true">Licencia Año</th>
                                        <th data-hide="phone,tablet">Cantidad</th>
                                        <th data-hide="phone,tablet">Tipo de Licencia</th>
                                        <th data-hide="phone,tablet">Empleado</th>
                                        <th class="text-right">Acciones</th>
                                        <th data-hide="all"></th>
                                    </tr>
                                </thead>
    							<tbody>
    								@foreach($licencias as $licencia)
                                        <tr class="footable-even">
                                            <td class="footable-visible footable-first-column"> 
                                                <span class="footable-toggle"></span>
                                                {{$licencia->licencia_anio}}
                                            </td>
                                            <td >{{$licencia->licencia_cantidad}}</td> 
                                            <td>{{$licencia->tipolicencia->tipolicencia_nombre}}</td>
                                            <td>{{$licencia->empleado->empleado_nombre}} {{$licencia->empleado->empleado_apellido}}</td>
                                            
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-default" href="{{ route('licencias.show', $licencia->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                <a class="btn btn-xs btn-default" href="{{ route('licencias.edit', $licencia->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
                                                <form action="{{ route('licencias.destroy', $licencia->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');" >
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                                </form>
                                            </td>
                                       
                                            <td> 
                                                @if($licencia->LicenciaDetalles->count())
                                                    <div class="table-responsive">
                            						<table class="table" >
                            							<thead>
                                                            <tr>
                                                                <th>Fecha Inicio</th>
                                                                <th>Fecha Fin</th>
                                                                <th>Dias</th>
                                                            </tr>
                                                        </thead>
                            							<tbody>
                            								@foreach($licencia->LicenciaDetalles as $detalle)
                                                                <tr>
                                                                    <td>{{ $detalle->fecha_desde }}</td>
                                                                    <td>{{ $detalle->fecha_hasta }}</td> 
                                                                    @php
                                                                        $dias= abs(strtotime($detalle->fecha_hasta) - strtotime($detalle->fecha_desde));
                                                                        $dias = $dias/(60 * 60 * 24) + 1;
                                                                    @endphp
                                                                    <td >{{ $dias  }}</td> 
                                                                    
                                                                </tr>
                                                            @endforeach
                            							</tbody>
                            						</table>
                            						</div>
                        					    @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <ul class="pagination pull-left"></ul>
                                            </td>
                                        </tr>
                                    </tfoot>
    							</tbody>

    						</table>
						    
                        @else
                            <h3 class="text-center alert alert-info">No hay datos para mostrar!</h3>
                        @endif
					</div>
                </div>
            </div>
        </div>
    </div>
 </div>
    
@endsection

