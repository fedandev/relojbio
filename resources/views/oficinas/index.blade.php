@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Oficinas</h5>
                </div>
                
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('oficinas.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
                    <div class="table-responsive">
                    
                        @if($oficinas->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th data-hide="phone,tablet">Descripcion</th>
                                        <th data-hide="phone,tablet">Codigo</th>
                                        <th data-hide="phone,tablet">Estado</th>
                                        <th data-hide="phone,tablet">Sucursal</th>
                                        <th data-hide="phone,tablet">Dispositivo</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($oficinas as $oficina)
                                        <tr>                                      
                                            <td>{{$oficina->oficina_nombre}}</td>
                                            <td>{{$oficina->oficina_descripcion}}</td>
                                            <td>{{$oficina->oficina_codigo}}</td>
                                            @if($oficina->oficina_estado == 1)
                                                <td>Activa</td>
                                            @else
                                                <td>Baja</td>
                                            @endif
                                            <td>
                                                <a href="{{ route('sucursals.show', $oficina->sucursal->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                                    {{  $oficina->sucursal->sucursal_nombre }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('dispositivos.show', $oficina->dispositivo->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                                    {{  $oficina->dispositivo->dispositivo_nombre }}
                                                </a>
                                            </td>
                                            
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('oficinas.show', $oficina->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('oficinas.edit', $oficina->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('oficinas.destroy', $oficina->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
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


