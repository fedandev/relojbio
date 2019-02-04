@extends('layouts.app')

@section('content')
<?php use App\Http\Controllers\DispositivosController ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Dispositivos</h5>
                    
                </div>
                
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('dispositivos.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
                    <div class="table-responsive">
                    
                        @if($dispositivos->count())
                          <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th data-hide="phone,tablet">Serial</th>
                                        <th data-hide="phone,tablet">Modelo</th>
                                        <th data-hide="phone,tablet">IP</th>
                                        <th data-hide="phone,tablet">Puerto</th>
                                        <th data-hide="phone,tablet">Usuario</th>
                                        <th data-hide="phone,tablet">Password</th>
                                        <th data-hide="phone,tablet">Empresa</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dispositivos as $dispositivo)
                                        <tr>                                      
                                            <td>{{$dispositivo->dispositivo_nombre}}</td>
                                            <td>{{$dispositivo->dispositivo_serial}}</td>
                                            <td>{{$dispositivo->dispositivo_modelo}}</td>
                                            <td>{{$dispositivo->dispositivo_ip}}</td>
                                            <td>{{$dispositivo->dispositivo_puerto}}</td>
                                            <td>{{$dispositivo->dispositivo_usuario}}</td>
                                            <td>{{ "************" }}</td>
                                            
                                            @if($dispositivo->empresa)
                                                <td><a href="{{ route('empresas.show', $dispositivo->empresa->id) }}" target="_blank">{{$dispositivo->empresa->empresa_nombre}}</a> </td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('dispositivos.show', $dispositivo->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('dispositivos.download', $dispositivo->id) }}">
                                                    <i class="fa fa-download"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('dispositivos.edit', $dispositivo->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('dispositivos.destroy', $dispositivo->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
        
                                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <ul class="pagination pull-left"></ul>
                                        </td>
                                    </tr>
                                </tfoot>
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


