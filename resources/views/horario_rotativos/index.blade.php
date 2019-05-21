@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Turnos Rotativos</h5>
                </div>
                
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('horario_rotativos.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
				    
                    <div class="table-responsive">
                    
                        @if($horario_rotativos->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th data-hide="phone,tablet">Día Comienzo</th>
                                        <th data-hide="phone,tablet">Días de trabajo</th>
                                        <th data-hide="phone,tablet">Días libres</th>
                                        <th data-hide="phone,tablet">Horario</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($horario_rotativos as $horario)
                                        <?php  ?>
                                        <tr>                                      
                                            <td>{{$horario->horariorotativo_nombre}}</td>
                                            <td>{{$horario->horariorotativo_diacomienzo}}</td>
                                            <td>{{$horario->horariorotativo_diastrabajo}}</td>
                                            <td>{{$horario->horariorotativo_diaslibres}}</td>
                                            <td>
                                                <a href="{{ route('horarios.show', $horario->horario->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                                    {{  $horario->horario->horario_nombre }}
                                                </a>
                                            </td>
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('horario_rotativos.show', $horario->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('horario_rotativos.edit', $horario->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('horario_rotativos.destroy', $horario->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
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