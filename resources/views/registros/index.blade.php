@extends('layouts.app')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Filtros</h5>
                </div>
                <div class="ibox-content">
                    <form method="GET" action="{{ route('registros.search') }}">
    		            <div class="input-group">
    		                
    		                    <div class="col-sm-4">
    		                        <p class="font-bold">Empleados</p>
    			                    <select class="select2_demo_2 form-control " name="ci" id="ci" value="{{ $empleado_cedula }}" required>
                                        @include('layouts.empleadosXcedula');
                                    </select>
    		                    </div>
    		                    <div class="col-sm-3">
    		                        <p class="font-bold">Fecha Desde</p>
    		                        <input class="form-control" type="date" name="fdesde" id="fdesde" value="{{ $fdesde }}">
                                </div>
                                <div class="col-sm-3">
                                    <p class="font-bold">Fecha Hasta</p>
    		                        <input class="form-control" type="date" name="fhasta" id="fhasta" value="{{ $fhasta }}">
                                </div>
    		          
                            <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filtrar </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Registros</h5>
                </div>
                
                <div class="ibox-content">
                    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('registros.load') }}"><i class="fa fa-cloud-upload"></i> Cargar</a>
                        </span>
                        <span class="input-group-btn">
                            </span>
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('registros.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
				    
                    <div class="table-responsive">
                        @if($registros->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>    
                                        <th>ID</th>
                                        <th>Nombre Empleado</th>
                                        <th data-hide="phone,tablet">Cedula</th>
                                        <th data-hide="phone,tablet">Fecha</th>
                                        <th data-hide="phone,tablet">Hora</th>
                                        <th data-hide="phone,tablet">Marca</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registros as $registro)
                                        <tr>                      
                                            <td>{{ $registro->id }}</td>
                                            <td>{{ $registro->empleado->empleado_nombre ." ". $registro->empleado->empleado_apellido}}</td>
                                            <td>{{ $registro->empleado->empleado_cedula}}</td>
                                            <td>{{ date( "d-m-Y", strtotime( $registro->registro_hora ) ) }}</td>
                                            <td>{{ date( "H:i:s", strtotime( $registro->registro_hora ) ) }}</td>
                                            @if($registro->	registro_tipo == "I")
                                                <td>Entrada</td>
                                            @else
                                                <td>Salida</td>
                                            @endif
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('registros.show', $registro->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('registros.edit', $registro->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('registros.destroy', $registro->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
        
                                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                                </form>
                                                
                                            </td>
                                        </tr>
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


@section('scripts')

    <script>
        $(document).ready(function(){
            var ci = $("#ci").attr('value');
            if(ci>0){
                $('#ci option[value="'+ ci +'"]').prop("selected", true);
            }
            
            $(".select2_demo_2").select2(); 
            
            
            $("#ci").css({ display: "none" });
            
        });
                  
    </script>
    
@endsection