@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Horarios</h5>
                </div>
                
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('horarios.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
                    <div class="table-responsive">
                        @if($horarios->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th data-hide="phone,tablet">Hora Entrada</th>
                                        <th data-hide="phone,tablet">Hora Salida</th>
                                        <th data-hide="phone,tablet">Aplica brake?</th>
                                        <th data-hide="all">Hora Comienzo Brake</th>
                                        <th data-hide="all">Hora Fin Brake</th>
                                        <th data-hide="phone,tablet">Tolerancia Llegada Tarde</th>
                                        <th data-hide="phone,tablet">Tolerancia Salida Antes</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($horarios as $horario)
                                        
                                        <tr>                                      
                                            <td>{{$horario->horario_nombre}}</td>
                                            <td>{{$horario->horario_entrada}}</td>
                                            <td>{{$horario->horario_salida}}</td>
                                            @if($horario->horario_haybrake == "S")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            <td>{{$horario->horario_comienzobrake}}</td>
                                            <td>{{$horario->horario_finbrake}}</td>
                                            <td>{{$horario->horario_tiempotarde}}</td>
                                            <td>{{$horario->horario_salidaantes}}</td>
                                            
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('horarios.show', $horario->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('horarios.edit', $horario->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
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