@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeIn">
        
       <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Llegadas tarde por Oficina<small> mes anterior</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart-ant"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Llegadas tarde por Oficina<small> mes actual</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart-act"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Horas Extras por Oficina <small>mes anterior</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart-hn-ant"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Horas Extras por Oficina <small>mes actual</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart-hn-act"></div>
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

    <script>
        $(document).ready(function () {
            DibujarGraficaPieMesAnterior();
            DibujarGraficaPieMesActual();
            DibujarGraficaHorasNocturnasAnterior();
            DibujarGraficaHorasNocturnasActual();
        });

        function DibujarGraficaPieMesAnterior(){
            Highcharts.chart('flot-pie-chart-ant', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: {point.y} (<b>{point.percentage:.1f}%</b>)'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Llegadas Tarde',
                    colorByPoint: true,
                    data: [
                        <?php
                            if(!empty($registrosPieMesAnt)){
                                foreach($registrosPieMesAnt as $registro){
                                     if ($registro === end($registrosPieMesAnt)) {
                                        echo "{ name: '".$registro[0]."', y: ". $registro[1]."}";
                                    }else{
                                        echo "{ name: '".$registro[0]."', y: ". $registro[1]."},";
                                    }
                                }
                            }
                        ?>
                    ]
                }]
            });
        }
        
        function DibujarGraficaPieMesActual(){
            Highcharts.chart('flot-pie-chart-act', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: {point.y} (<b>{point.percentage:.1f}%</b>)'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Llegadas Tarde',
                    colorByPoint: true,
                    data: [
                        <?php
                            if(!empty($registrosPieMesActual)){
                                foreach($registrosPieMesActual as $registro){
                                     if ($registro === end($registrosPieMesActual)) {
                                        echo "{ name: '".$registro[0]."', y: ". $registro[1]."}";
                                    }else{
                                        echo "{ name: '".$registro[0]."', y: ". $registro[1]."},";
                                    }
                                }
                            }
                        ?>
                    ]
                }]
            });
        }
        
        function DibujarGraficaHorasNocturnasAnterior(){
            Highcharts.chart('flot-pie-chart-hn-ant', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: {point.y} (<b>{point.percentage:.1f}%</b>)',
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Horas Nocturnas',
                    colorByPoint: true,
                    data: [
                        <?php
                            if(!empty($registrosHorasNoctAnterior)){
                                foreach($registrosHorasNoctAnterior as $registro){
                                     if ($registro === end($registrosHorasNoctAnterior)) {
                                        echo "{ name: '".$registro[0]."', y: ". $registro[1]."}";
                                    }else{
                                        echo "{ name: '".$registro[0]."', y: ". $registro[1]."}";
                                    }
                                }
                            }
                        ?>
                    ]
                }]
            });
        }
        
        function DibujarGraficaHorasNocturnasActual(){
            Highcharts.chart('flot-pie-chart-hn-act', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: {point.y} (<b>{point.percentage:.1f}%</b>)',
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Horas Nocturnas',
                    colorByPoint: true,
                    data: [
                        <?php
                            if(!empty($registrosHorasNoctActual)){
                                foreach($registrosHorasNoctActual as $registro){
                                     if ($registro === end($registrosHorasNoctActual)) {
                                        echo "{ name: '".$registro[0]."', y: ". $registro[1]."}";
                                    }else{
                                        echo "{ name: '".$registro[0]."', y: ". $registro[1]."}";
                                    }
                                }
                            }
                        ?>
                    ]
                }]
            });
        }
    </script>
    
@endsection