@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Feriados</h5>
                    
                </div>
                
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('feriados.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
                    <div class="table-responsive">
                    
                        @if($feriados->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th data-hide="phone,tablet">Coeficiente</th>
                                        <th data-hide="phone,tablet">Minimo Horas</th>
                                        <th data-hide="phone,tablet">Fecha</th>
                                        <th data-hide="phone,tablet">Laborable?</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feriados as $feriado)
                                        <?php  ?>
                                        <tr>                                      
                                            <td>{{$feriado->feriado_nombre}}</td>
                                            <td>{{$feriado->feriado_coeficiente}}</td>
                                            <td>{{$feriado->feriado_minimo}}</td>
                                            <td>{{ formatFecha($feriado->feriado_fecha) }}</td>
                                            @if($feriado->feriado_laborable == "1")
                                                <td><i class="fa fa-check text-navy"></i></td>
                                            @else
                                                <td><i class="fa fa-times text-danger"></i></td>
                                            @endif
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('feriados.show', $feriado->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('feriados.edit', $feriado->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('feriados.destroy', $feriado->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
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