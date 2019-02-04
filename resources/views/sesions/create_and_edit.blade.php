@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Sesion /
                    @if($sesion->id)
                        Edit #{{$sesion->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($sesion->id)
                    <form action="{{ route('sesions.update', $sesion->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('sesions.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="sesion_equipo-field">Sesion_equipo</label>
                	<input class="form-control" type="text" name="sesion_equipo" id="sesion_equipo-field" value="{{ old('sesion_equipo', $sesion->sesion_equipo ) }}" />
                </div> 
                <div class="form-group">
                    <label for="sesion_fecha-field">Sesion_fecha</label>
                    <input class="form-control" type="text" name="sesion_fecha" id="sesion_fecha-field" value="{{ old('sesion_fecha', $sesion->sesion_fecha ) }}" />
                </div> 
                <div class="form-group">
                    <label for="sesion_hora-field">Sesion_hora</label>
                    <input class="form-control" type="text" name="sesion_hora" id="sesion_hora-field" value="{{ old('sesion_hora', $sesion->sesion_hora ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('sesions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection