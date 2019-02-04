@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Sesion / Show #{{ $sesion->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('sesions.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('sesions.edit', $sesion->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Sesion_equipo</label>
<p>
	{{ $sesion->sesion_equipo }}
</p> <label>Sesion_fecha</label>
<p>
	{{ $sesion->sesion_fecha }}
</p> <label>Sesion_hora</label>
<p>
	{{ $sesion->sesion_hora }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
