@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Lista de Autorizaciones de Horas Extras</h5>
                </div>
				
				<div class="ibox-content">
				    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				            <a class="btn btn-success" href="{{ route('autorizacions.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
				    
					<div class="table-responsive">

        
                    @if($autorizacions->count())
                        <table class="footable table table-stripped " data-filter=#filter data-page="true">
                            <thead>
                                <tr>
                                    <th>Empleado</th>
                                    <th>Fecha Desde</th>
                                    <th>Fecha Hasta</th>
                                    <th>Antes de Hora</th>
                                    <th>Despues de Hora</th>
                                    <th>Descripción</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach($autorizacions as $autorizacion)
                                    <tr>
                                        <td><a href="{{ route('empleados.show', $autorizacion->empleado->id) }}" target="_blank">{{$autorizacion->empleado->empleado_nombre}} {{$autorizacion->empleado->empleado_apellido}} </a> </td>
                                        <td>{{formatFecha($autorizacion->autorizacion_fechadesde) }}</td>
                                        <td>{{formatFecha($autorizacion->autorizacion_fechahasta) }}</td>
                                        <td>
                                            @if ($autorizacion->autorizacion_antesHorario == '1')
                                                <i class="fa fa-check text-navy"></i>
                                            @else
                                                <i class="fa fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($autorizacion->autorizacion_despuesHorario == '1')
                                                <i class="fa fa-check text-navy"></i>
                                            @else
                                                <i class="fa fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td>{{$autorizacion->autorizacion_descripcion}}</td>
                                        <td class="text-right">
                                            <a class="btn btn-xs btn-default" href="{{ route('autorizacions.show', $autorizacion->id) }}">
                                                <i class="fa fa-eye"></i> 
                                            </a>
                                            
                                            <a class="btn btn-xs btn-default" href="{{ route('autorizacions.edit', $autorizacion->id) }}">
                                                <i class="fa fa-edit"></i> 
                                            </a>
    
                                            <form action="{{ route('autorizacions.destroy', $autorizacion->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar');">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">
    
                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
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