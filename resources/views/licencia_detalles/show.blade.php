@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-edit"></i> Detalle de Licencia / Ver #{{ $licencia_detalle->id }}
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    
                    
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group"><label class="col-lg-2 control-label">Empleado </label>
                                <div class="col-lg-3"><p class="form-control-static">{{  $licencia_detalle->licencia->empleado->empleado_nombre }} {{  $licencia_detalle->licencia->empleado->empleado_apellido }}</p></div>
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Tipo de Licencia</label>
                                <div class="col-lg-3"><p class="form-control-static">{{  $licencia_detalle->licencia->tipolicencia->tipolicencia_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Fecha Desde</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  formatFecha($licencia_detalle->fecha_desde) }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Fecha Hasta</label>
                                <div class="col-lg-2"><p class="form-control-static">{{  formatFecha($licencia_detalle->fecha_hasta) }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Aplica</label>
                                <div class="col-sm-5">
                                    <label class="checkbox-inline">
                                    <input type="checkbox" name="aplica_sabado" id="aplica_sabado-field" value="S" {{ $licencia_detalle->aplica_sabado == 'S' ? 'checked' : '' }} disabled="true"> Sabado </label> <label class="checkbox-inline">
                                        <input type="checkbox" name="aplica_domingo" id="aplica_domingo-field" value="S" {{ $licencia_detalle->aplica_domingo == 'S' ? 'checked' : '' }} disabled="true"> Domingo </label> <label class="checkbox-inline">
                                        <input type="checkbox" name="aplica_libre" id="aplica_libre-field" value="S" {{ $licencia_detalle->aplica_libre == 'S' ? 'checked' : '' }} disabled="true"> Día Libre</label>
                                </div>
                            </div>
                            
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Observaciones </label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $licencia_detalle->licencia_observaciones }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('licencia_detalles.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>


@endsection
