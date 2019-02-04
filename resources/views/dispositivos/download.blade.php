@extends('layouts.app')

@section('content')
    <?php 
    //use App\Http\Controllers\DispositivosController;
    //include(app_path().'/Libs/zklib.php');
    
    //$zk = new ZKLib($dispositivo->dispositivo_ip, $dispositivo->dispositivo_puerto);
    //$ret = $zk->connect();
    ?>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de marcas</h5>
                        
                    </div>
                    
                    <div class="ibox-content">
                        <div class="input-group">
    				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
    				        <span class="input-group-btn">
    				             <a class="btn btn-success" href="{{ route('dispositivos.download', $dispositivo->id) }}"><i class="fa fa-plus"></i> Descargar</a>
                            </span>
    				    </div>
                        <div class="table-responsive"> 
                            @if($ret)
                                <?php // $marcas = $zk->getAttendance(); ?>
                                @if($marcas->count())
                                    <table class="footable table table-stripped" data-page-size="8" data-filter=#filter >
                                        <thead>
                                            <tr>
                                                <th data-hide="phone,tablet">Código</th>
                                                <th data-hide="phone,tablet">Entrada / Salida</th>
                                                <th data-hide="phone,tablet">Fecha</th>
                                                <th data-hide="phone,tablet">Hora</th>
                                                <th class="text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($marcas as $marca)
                                                <?php  ?>
                                                <tr>                                      
                                                    <td>{{ $marca[1] }}</td>
                                                    @if($marca[2] == 1)
                                                        <td>{{ "Salida" }}</td>
                                                    @else
                                                        <td>{{ "Entrada" }}</td>
                                                    @endif
                                                    <td>{{ date( "d-m-Y", strtotime( $marca[3] ) ) }}</td>
                                                    <td>{{ date( "H:i:s", strtotime( $marca[3] ) ) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
        
                                    </table>
                                   
                                @else
                                    <h3 class="text-center alert alert-info">No hay datos para mostrar!</h3>
                                @endif
                            @else
                                <h3 class="text-center alert alert-info"><img src="/Disconnected.png"  width="5%">Reloj desconectado!</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')

<!-- Page-Level Scripts -->
<script>
    
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                 customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });

  

</script>

@endsection