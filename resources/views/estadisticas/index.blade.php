@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> Estadistica
                    <a class="btn btn-success pull-right" href="{{ route('estadisticas.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($estadisticas->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Fecha_desde</th> <th>Fecha_hasta</th> <th>Total_horas_trabajadas</th> <th>Total_horas_extras</th> <th>Total_llegadas_tardes</th> <th>Total_debe_trabajar</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($estadisticas as $estadistica)
                                <tr>
                                    <td class="text-center"><strong>{{$estadistica->id}}</strong></td>

                                    <td>{{$estadistica->fecha_desde}}</td> <td>{{$estadistica->fecha_hasta}}</td> <td>{{$estadistica->total_horas_trabajadas}}</td> <td>{{$estadistica->total_horas_extras}}</td> <td>{{$estadistica->total_llegadas_tardes}}</td> <td>{{$estadistica->total_debe_trabajar}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('estadisticas.show', $estadistica->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('estadisticas.edit', $estadistica->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('estadisticas.destroy', $estadistica->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $estadisticas->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection