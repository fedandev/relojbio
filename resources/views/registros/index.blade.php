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
                    <form method="GET" action="{{ route('registros.search') }}" novalidate>
    		            <div class="input-group">
    		                
    		                    <div class="col-sm-4">
    		                        <p class="font-bold">Empleados</p>
    			                    <select class="select2_demo_2 form-control " name="ci" id="ci" value="{{ $empleado_cedula }}" required >
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
                                    <button type="submit" class="btn btn-primary" id='filtrar'><i class="fa fa-filter"></i> Filtrar </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Registros</h5>
                </div>
                <form action="{{ route('registros.del') }}" method="post" onsubmit="return confirm('Esta seguro que desea eliminar los registros seleccionados?')";>
                            {!! csrf_field() !!}
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
                        <span class="input-group-btn">
                            </span>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-danger">Eliminar Seleccionados</button>
                        </span>
				    </div>
				    
                    <div class="table-responsive">
                        @if($registros->count())
                        <!--<form action="{{ route('registros.del') }}" method="post" onsubmit="return confirm('Esta seguro que desea eliminar los registros seleccionados?')";>
                            {!! csrf_field() !!}-->
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>    
                                        <th></th>
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
                                        @if(isset($registro->empleado))
                                        <tr>
                                            <td><input type="checkbox" name="delid[]" value="{{ $registro->id }}"></input></td>
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
                                                
                                                <!--<a class="btn btn-xs btn-default open_modal" value =href="{{ route('registros.edit', $registro->id) }}">-->
                                                <!--    <i class="fa fa-edit"></i> -->
                                                <!--</a>-->
                                                
                                                <button class="btn btn-xs btn-default open_modal" value="{{ $registro->id }}" type="button">
                                                    <i class="fa fa-edit"></i> 
                                                </button>
        
                                                <!--<form action="{{ route('registros.destroy', $registro->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
        
                                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                                </form>-->
                                                
                                            </td>
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
                            <!--<button type="submit" class="btn btn-xs btn-danger">Eliminar Seleccionados</button>-->
                        <!--</form>-->
                        @else
                            <h3 class="text-center alert alert-info">No hay datos para mostrar!</h3>
                        @endif
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
 </div>
    
    @include('layouts.modalEditRegistros');
 
 
 
@endsection


@section('scripts')
    <script src="{{ asset('js/plugins/jquery.mask.js') }}" type="text/javascript"></script>
    

    <script>
        $(document).ready(function(){
            
            var ci = $("#ci").attr('value');
            $('#ci option[value="'+ ci +'"]').prop("selected", true);
           
            $(".select2_demo_2").select2(); 
            
            $("#ci").css({ display: "none" });
            
            //MODAL----

            //get base URL *********************
            var url = $('#url').val();
        
        
            //display modal form for creating new product *********************
            $('#btn_add').click(function(){
                $('#btn-save').val("add");
                $('#frmRegistros').trigger("reset");
                $('#myModal').modal('show');
            });
        
            $('#r_hora').mask('00:00:00');
        
            //display modal form for product EDIT ***************************
            $(document).on('click','.open_modal',function(){
                var registro_id = $(this).val();
                
                // Populate Data in Edit Modal Form
                $.ajax({
                    type: "GET",
                    url: url + '/registros/modal/' + registro_id,
                    success: function (data) {
                        //console.log(data);
                        $('#r_id').val(data.id);
                        
                        var datetime = data.registro_hora;
                        var format = datetime.substr(-8);
                        $("#r_hora").val(format);
                        
                        $('#r_fecha').val(data.registro_fecha);
                        $('#r_tipo').val(data.registro_tipo);
                        $('#r_comentarios').val(data.registro_comentarios);
                        $('#r_cedula').val(data.fk_empleado_cedula);
                        $('#r_dispositivo').val(data.fk_dispositivo_id);
                        $('#btn-save').val("update");
                        $('#myModal').modal('show');
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        
        
        
            //update ***************************
            $("#btn-save").click(function (e) {
            
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });
        
                e.preventDefault(); 
                var formData = {
                    registro_hora: $('#r_hora').val(),
                    registro_fecha: $('#r_fecha').val(),
                    registro_tipo:  $('#r_tipo').val(),
                    registro_comentarios: $('#r_comentarios').val(),
                    fk_empleado_cedula: $('#r_cedula').val(),
                    fk_dispositivo_id: $('#r_dispositivo').val(),
                }
        
                //used to determine the http verb to use [add=POST], [update=PUT]
                var state = $('#btn-save').val();
                var type = "POST"; //for creating new resource
                var registro_id = $('#r_id').val();;
                var my_url = url;
                if (state == "update"){
                    type = "PUT"; //for updating existing resource
                    my_url += '/registros/modalUpdate/' + registro_id;
                }
                //console.log(formData);
                $.ajax({
                    type: type,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        //console.log(data);
                        $('#frmRegistros').trigger("reset");
                        $('#myModal').modal('hide');
                        $('#filtrar').trigger('click');
                        
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        
        
     
            
        });
                  
    </script>
    
    

@endsection