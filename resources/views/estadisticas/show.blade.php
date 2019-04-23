@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Estadistica / Show #{{ $estadistica->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('estadisticas.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('estadisticas.edit', $estadistica->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Fecha_desde</label>
<p>
	{{ $estadistica->fecha_desde }}
</p> <label>Fecha_hasta</label>
<p>
	{{ $estadistica->fecha_hasta }}
</p> <label>Total_horas_trabajadas</label>
<p>
	{{ $estadistica->total_horas_trabajadas }}
</p> <label>Total_horas_extras</label>
<p>
	{{ $estadistica->total_horas_extras }}
</p> <label>Total_llegadas_tardes</label>
<p>
	{{ $estadistica->total_llegadas_tardes }}
</p> <label>Total_debe_trabajar</label>
<p>
	{{ $estadistica->total_debe_trabajar }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
