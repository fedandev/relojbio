@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Lista de libres y medicas</h5>
                </div>
				
				<div class="ibox-content">
				    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('libre_detalles.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
				    
					<div class="table-responsive">
                    
					    @if($libre_detalles->count())
    						<table class="footable table table-stripped " data-filter=#filter data-page="true">
    							<thead>
                                    <tr>
                                        <th data-hide="phone,tablet">Fecha Desde</th>
                                        <th data-hide="phone,tablet">Fecha Hasta</th>
                                        <th data-hide="phone,tablet">Empleado</th>
                                        <th data-hide="phone,tablet">Tipo Libre</th>
                                        <th data-hide="phone,tablet">Observaciones</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
    							<tbody>
    								@foreach($libre_detalles as $libre)
                                        <tr>
                                            <td>{{ formatFecha($libre->fecha_desde) }}</td>
                                            <td>{{ formatFecha($libre->fecha_hasta) }}</td>
                                            <td><a href="{{ route('empleados.show', $libre->Empleado->id ) }}" target="_blank">{{ $libre->Empleado->empleado_nombre }} {{ $libre->empleado->empleado_apellido }} </a> </td>
                                            <td><a href="{{ route('tipo_libres.show', $libre->TipoLibre->id ) }}" target="_blank">{{ $libre->TipoLibre->nombre }} </a> </td>
                                       
                                            <td>{{ $libre->comentarios }}</td>
                                            
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-default" href="{{ route('libre_detalles.show', $libre->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <!--<a class="btn btn-xs btn-default" href="{{ route('libre_detalles.edit', $libre->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>-->
        
                                                <form action="{{ route('libre_detalles.destroy', $libre->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');" >
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
            
                                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                                </form>
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

