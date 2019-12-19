@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Horas trabajadas</h5>
                                <span class="label label-primary float-right">Mes</span>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{ $HorasTrabajadas }} hs</h1>
                                <div class="stat-percent font-bold text-navy" data-toggle="tooltip" data-placement="left" title="Total a trabajar: {{ $TotalHorasAtrabajar }} hs , Trabajado: {{ $porcentajeHorasAtrabajar }} %"><span id="1" class="pie">{{ $porcentajeHorasAtrabajar }}/100</span> </div> 
                                <small>Total horas </small>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title">
                                 <h5>Llegadas tardes</h5>
                                <span class="label label-warning float-right">Mes</span>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{ $LlegadasTardes }} hs</h1>
                                <small>Total llegadas tardes</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Horas extras</h5>
                                <span class="label label-success float-right">Mes</span>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{ $HorasExtras }} hs</h1>
                                <small>Total horas extras</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-content">
                                <div>
                                
                                    </span>
                                    <h3 class="font-bold no-margins">
                                        Ilustración anual de horas
                                    </h3>
                                    
                                </div>
        
                                <div class="m-t-sm">
        
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div>
                                                <canvas id="lineChart" height="200"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="stat-list m-t-lg">
                                                <li>
                                                    <h2 class="no-margins">{{ $HorasTrabajadasAnual }} hs</h2>
                                                    <small>Total horas trabajadas en el año</small>
                                                    <div class="progress progress-mini">
                                                        <div class="progress-bar" style="width: 100%;"></div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <h2 class="no-margins ">{{ $horasTrabajadasMesAnterior }} hs </h2>
                                                    <small>Total horas trabajadas en el ultimo mes</small>
                                                    <div class="progress progress-mini">
                                                        <div class="progress-bar" style="width: 100%;"></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
        
                                </div>
        
                                <div class="m-t-md">
                                    
                                    <small>
                                        <strong>Analisis de datos:</strong> Los valores estan actualizados en todo momento.
                                    </small>
                                </div>
        
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
           
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Empleados del mes </h5>
                        <span class="label label-danger float-right">Mes</span>
                    </div>
                    <div class="ibox-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="fa fa-trophy fa-5x"></i>
                                </div>
                                <div class="col-sm-3">
                                    @if($rankingEmpleados <> null)
                                      @if($rankingEmpleados[0]['porcentaje'] <> 0)
                                      <h3 class="float-right">#1 {{  $rankingEmpleados[0]['empleado']}} </h3>
                                      @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                            
                        <div class="row">
                            <div class="col-lg-12">
                                <table class=" footable table table-stripped" data-page="true" >
                                    <thead>
                                        <tr>
                                            <th data-sort-ignore="true" style="width: 1%" class="text-center">#</th>
                                            <th data-sort-ignore="true">Empleado</th>
                                            <th data-sort-ignore="true" class="text-center" >%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach($rankingEmpleados as $empleado)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $i }}</td>
                                            <td> {{ $empleado['empleado'] }} </td>
                                            <td class="text-center" data-toggle="tooltip" data-placement="left" title=" {{ $empleado['porcentaje'] }} %"> <span class="pie empleado" >{{ $empleado['porcentaje'] }}/100</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
                                                <ul class="pagination pull-left"></ul>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>  
                        </div>
                        
                        
                        
                    </div>
                </div>

            </div>
            
           
        </div>
        
        <div class="row">
            @include('vendor.home_layouts.table_autorizaciones', ['advertencias' => $advertencias])
        </div>
        
    </div>
@endsection

@section('scripts')

    <script src="{{ secure_asset('js/plugins/jquery.peity.min.js') }}" type="text/javascript"></script>
    <script src="{{ secure_asset('js/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ secure_asset('js/plugins/Chart.min.js') }}" type="text/javascript"></script>
     
    
    <script>
        $(document).ready(function () {
            $("#1").peity("pie", {
                fill: ['#1ab394', '#d7d7d7', '#ffffff']
            })
             $("#3").peity("pie", {
                fill: ['#f8ac59', '#d7d7d7', '#ffffff']
            })
             $("#2").peity("pie", {
                fill: ['#1c84c6', '#d7d7d7', '#ffffff']
            })
             $("#4").peity("pie", {
                fill: ['#ed5565', '#d7d7d7', '#ffffff']
            })
            
            
           
            $(".empleado").peity("pie", {
                fill: ['#1ab394', '#d7d7d7', '#ffffff'],
                width: 55
            })

            
            var lineData = {
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                datasets: [
                    {
                        label: "Horas Trabajadas",
                        backgroundColor: "rgba(26,179,148,0.5)",
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: [  
                             <?php 
                                if(!empty($arrayHorasTrabajadas)){
                                    foreach($arrayHorasTrabajadas as $registro){
                                         if ($registro === end($arrayHorasTrabajadas)) {
                                            echo $registro;
                                        }else{
                                            echo $registro.",";
                                        }
                                    }
                                }
                            ?>
                        ]
                    },
                    {
                        label: "Horas extras",
                        backgroundColor: "rgba(76,57,254,0.5)",
                        borderColor: "rgba(76,57,254,1)",
                        pointBackgroundColor: "rgba(76,57,254,1)",
                        pointBorderColor: "#fff",
                        data: [  
                             <?php 
                                if(!empty($arrayHorasExtras)){
                                    foreach($arrayHorasExtras as $registro){
                                         if ($registro === end($arrayHorasExtras)) {
                                            echo $registro;
                                        }else{
                                            echo $registro.",";
                                        }
                                    }
                                }
                            ?>
                        ]
                    },
                    {
                        label: "Llegadas tardes",
                        backgroundColor: "rgba(250,160,25,0.5)",
                        borderColor: "rgba(250,160,25,1)",
                        pointBackgroundColor: "rgba(250,160,25,1)",
                        pointBorderColor: "#fff",
                        data: [  
                             <?php 
                                if(!empty($arrayLlegadasTardes)){
                                    foreach($arrayLlegadasTardes as $registro){
                                         if ($registro === end($arrayLlegadasTardes)) {
                                            echo $registro;
                                        }else{
                                            echo $registro.",";
                                        }
                                    }
                                }
                            ?>
                        ]
                    }
                ]
            };

            var lineOptions = {
                responsive: true
            };

            
            
            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {type: 'line', data: lineData, options: lineOptions});
            
            
            
            
        });

        
    </script>
    
@endsection