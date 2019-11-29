@extends('layouts.app')

@section('content')
<?php use App\Http\Controllers\RegistrosController ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Registros</h5>
                    
                </div>
                <div class="ibox-content">
                    <div class="input-group">
				        <h3>Horas trabajdas en el mes: {{$horas}}</h3>
				    </div>
                    <div class="table-responsive">
                        @if($registros->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>    
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th data-hide="phone,tablet">Cedula</th>
                                        <th data-hide="phone,tablet">Fecha</th>
                                        <th data-hide="phone,tablet">Hora</th>
                                        <th data-hide="phone,tablet">Marca</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registros as $registro)
                                        @if(isset($registro->empleado))
                                        <tr>
                                            <td>{{ $registro->id }}</td>
                                            <td>{{ $registro->empleado->empleado_nombre ." ". $registro->empleado->empleado_apellido}}</td>
                                            <td>{{ $registro->empleado->empleado_cedula}}</td>
                                            <td>{{ date( "d-m-Y", strtotime( $registro->registro_hora ) ) }}</td>
                                            <td>{{ date( "H:i:s", strtotime( $registro->registro_hora ) ) }}</td>
                                            
                                            @if($registro->registro_tipo == "I")
                                                <td>Entrada</td>
                                            @else
                                                <td>Salida</td>
                                            @endif
                        
                                        </tr>
                                        @endif
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <td colspan="7">
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