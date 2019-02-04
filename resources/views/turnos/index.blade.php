@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Turnos</h5>
                </div>
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('turnos.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
                    <div class="table-responsive">
                    
                        @if($turnos->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th data-hide="phone,tablet">Lunes</th>
                                        <th data-hide="phone,tablet">Martes</th>
                                        <th data-hide="phone,tablet">Miercoles</th>
                                        <th data-hide="phone,tablet">Jueves</th>
                                        <th data-hide="phone,tablet">Viernes</th>
                                        <th data-hide="phone,tablet">Sabado</th>
                                        <th data-hide="phone,tablet">Domingo</th>
                                        <th data-hide="phone,tablet">Horario</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($turnos as $turno)
                                        <?php ?>
                                        <tr>
                                            <td>{{$turno->turno_nombre}}</td>
                                            @if($turno->turno_lunes == "1")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            @if($turno->turno_martes == "1")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            @if($turno->turno_miercoles == "1")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            @if($turno->turno_jueves == "1")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            @if($turno->turno_viernes == "1")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            @if($turno->turno_sabado == "1")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            @if($turno->turno_domingo == "1")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            
                                            @if ($turno->horario)
                                                <td><a href="{{ route('horarios.show', $turno->horario->id) }}" target="_blank">{{ $turno->horario->horario_nombre }} </a> </td>
                                            @else
                                                <td> </td>
                                            @endif
                                         
                                            
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('turnos.show', $turno->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('turnos.edit', $turno->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
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



