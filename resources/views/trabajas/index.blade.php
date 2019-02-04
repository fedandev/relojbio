@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de horarios asociados a empleados</h5>
                </div>
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('trabajas.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
                    <div class="table-responsive">
                    
                        @if($trabajas->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>
                                        <th>Empleado</th>
                                        <th data-hide="phone,tablet">Fecha Inicio</th>
                                        <th data-hide="phone,tablet">Fecha Fin</th>
                                        <th data-hide="phone,tablet">Tipo Horario</th>
                                        <th data-hide="phone,tablet">Horario</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trabajas as $trabaja)
                                        <?php ?>
                                        <tr>
                                            <td><a href="{{ route('empleados.show', $trabaja->empleado->id) }}" target="_blank">{{$trabaja->empleado->empleado_nombre}} {{$trabaja->empleado->empleado_apellido}} </a> </td>
                                            <td>{{formatFecha($trabaja->trabaja_fechainicio) }}</td>
                                            <td>{{formatFecha($trabaja->trabaja_fechafin)}}</td>
                                            @if(isset($trabaja->fk_horariorotativo_id))
                                                <td>Rotativo</td>
                                                <td><a href="{{ route('horario_rotativos.show', $trabaja->horariorotativo->id) }}" target="_blank">{{$trabaja->horariorotativo->horariorotativo_nombre}} </a> </td>
                                            @elseif(isset($trabaja->fk_turno_id))
                                                <td>Turno Fijo</td>
                                                <td><a href="{{ route('turnos.show', $trabaja->turno->id) }}" target="_blank">{{$trabaja->turno->turno_nombre}} </a> </td>
                                            @elseif(isset($trabaja->fk_horariosemanal_id))
                                                <td>Semanal</td>
                                                <td><a href="{{ route('horario_semanals.show', $trabaja->horariosemanal->id) }}" target="_blank">{{$trabaja->horariosemanal->horariosemanal_nombre}} </a> </td>
                                            @endif
                        
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('trabajas.show', $trabaja->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('trabajas.edit', $trabaja->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('trabajas.destroy', $trabaja->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
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




