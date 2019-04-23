@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Estadistica /
                    @if($estadistica->id)
                        Edit #{{$estadistica->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($estadistica->id)
                    <form action="{{ route('estadisticas.update', $estadistica->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('estadisticas.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="fecha_desde-field">Fecha_desde</label>
                    <input class="form-control" type="text" name="fecha_desde" id="fecha_desde-field" value="{{ old('fecha_desde', $estadistica->fecha_desde ) }}" />
                </div> 
                <div class="form-group">
                    <label for="fecha_hasta-field">Fecha_hasta</label>
                    <input class="form-control" type="text" name="fecha_hasta" id="fecha_hasta-field" value="{{ old('fecha_hasta', $estadistica->fecha_hasta ) }}" />
                </div> 
                <div class="form-group">
                	<label for="total_horas_trabajadas-field">Total_horas_trabajadas</label>
                	<input class="form-control" type="text" name="total_horas_trabajadas" id="total_horas_trabajadas-field" value="{{ old('total_horas_trabajadas', $estadistica->total_horas_trabajadas ) }}" />
                </div> 
                <div class="form-group">
                	<label for="total_horas_extras-field">Total_horas_extras</label>
                	<input class="form-control" type="text" name="total_horas_extras" id="total_horas_extras-field" value="{{ old('total_horas_extras', $estadistica->total_horas_extras ) }}" />
                </div> 
                <div class="form-group">
                	<label for="total_llegadas_tardes-field">Total_llegadas_tardes</label>
                	<input class="form-control" type="text" name="total_llegadas_tardes" id="total_llegadas_tardes-field" value="{{ old('total_llegadas_tardes', $estadistica->total_llegadas_tardes ) }}" />
                </div> 
                <div class="form-group">
                	<label for="total_debe_trabajar-field">Total_debe_trabajar</label>
                	<input class="form-control" type="text" name="total_debe_trabajar" id="total_debe_trabajar-field" value="{{ old('total_debe_trabajar', $estadistica->total_debe_trabajar ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('estadisticas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection