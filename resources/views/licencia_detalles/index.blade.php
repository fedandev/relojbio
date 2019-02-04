@extends('layouts.app')

@section('content')
<?php use App\Http\Controllers\LicenciaDetallesController ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Lista de detalles de licencias tomadas</h5>
                </div>
				
				<div class="ibox-content">
				    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('licencia_detalles.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
				    
					<div class="table-responsive">
                    
					    @if($licencia_detalles->count())
    						<table class="footable table table-stripped " data-filter=#filter data-page="true">
    							<thead>
                                    <tr>
                                        <th data-hide="phone,tablet">Fecha Inicio</th>
                                        <th data-hide="phone,tablet">Fecha Fin</th>
                                        <th data-hide="phone,tablet">Aplica Sabado?</th>
                                        <th data-hide="phone,tablet">Aplica Domingo?</th>
                                        <th data-hide="phone,tablet">Aplica Libre?</th>
                                        <th data-hide="phone,tablet">Licencia</th>
                                        <th data-hide="phone,tablet">Empleado</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
    							<tbody>
    								@foreach($licencia_detalles as $licencia)
                                        <tr>
                                            <td>{{ formatFecha($licencia->fecha_desde) }}</td>
                                            <td>{{ formatFecha($licencia->fecha_hasta) }}</td> 
                                            @if($licencia->aplica_sabado == "S")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            @if($licencia->aplica_domingo == "S")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            @if($licencia->aplica_libre == "S")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                           
                                            @if($licencia->licencia)
                                                <td><a href="{{ route('licencias.show', $licencia->licencia->id) }}" target="_blank">{{ $licencia->licencia->licencia_anio }}</a> </td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>{{ $licencia->licencia->empleado->empleado_nombre }} {{ $licencia->licencia->empleado->empleado_apellido }}</td>
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-default" href="{{ route('licencia_detalles.show', $licencia->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <!--<a class="btn btn-xs btn-default" href="{{ route('licencia_detalles.edit', $licencia->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>-->
        
                                                <form action="{{ route('licencia_detalles.destroy', $licencia->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');" >
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
            
                                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <td colspan="10">
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

