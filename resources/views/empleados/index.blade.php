@extends('layouts.app')

@section('content')
<?php use App\Http\Controllers\EmpleadosController ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Empleados</h5>
                    
                </div>
                
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('empleados.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
                    <div class="table-responsive">
                    
                        @if($empleados->count())
                           <table class="footable table table-stripped" data-page-size="8" data-filter=#filter >
                                <thead>
                                    <tr>
                                        <th data-hide="phone,tablet">Cédula</th>
                                        <th data-hide="phone,tablet">Código</th>
                                        <th >Nombre</th>
                                        <th >Apellido</th>
                                        <th data-hide="phone,tablet">Teléfono</th>
                                        <th data-hide="phone,tablet">Tipo Empleado</th>
                                        <th data-hide="phone,tablet">Oficina</th>
                                        <th data-hide="phone,tablet">Estado</th>
                                        <th data-hide="phone,tablet" class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($empleados as $empleado)
                                        <?php  ?>
                                        <tr>                                      
                                            <td>{{$empleado->empleado_cedula}}</td>
                                            <td>{{$empleado->empleado_codigo}}</td>
                                            <td>{{$empleado->empleado_nombre}}</td>
                                            <td>{{$empleado->empleado_apellido}}</td>
                                            <td>{{$empleado->empleado_telefono}}</td>
                                            <td>{{$empleado->tipoempleado->tipoempleado_nombre}}</td>
                                            <td>{{$empleado->oficina->oficina_nombre}}</td>
                                            @if($empleado->empleado_estado == "Activo")
                                                <td style="color: green;">Activo</td>
                                            @else
                                                <td style="color: red;">Baja</td>
                                            @endif
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('empleados.show', $empleado->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('empleados.edit', $empleado->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
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


