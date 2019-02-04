@extends('layouts.app')

@section('content')
<?php use App\Http\Controllers\AuditsController ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de Auditoria</h5>
                </div>
                <div class="ibox-content">
                    <div>
				        <input type="text" class="form-control" id="filter"  placeholder="Filtrar...">
				    </div>
                    <div class="table-responsive">
                        @if($audits->count())
                            <table class="footable table table-stripped " data-filter=#filter data-page="true">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th data-hide="phone,tablet">Modelo</th>
                                        <th data-hide="phone,tablet">Usuario</th>
                                        <th data-hide="phone,tablet">IP</th>
                                        <th data-hide="phone,tablet">Fecha</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($audits as $audit)
                                        <tr>                                      
                                            <td>{{ trans('generic.'.$audit->event) }}</td>
                                            <td>{{ class_basename($audit->auditable_type) }}</td>
                                            <td>{{$audit->User->nombre}}</td>
                                            <td>{{$audit->ip_address}}</td>
                                            <td>{{$audit->created_at}}</td>
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-default" href="{{ route('audits.show', $audit->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
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
