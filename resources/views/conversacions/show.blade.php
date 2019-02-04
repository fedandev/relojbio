@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Conversacion / Show #{{ $conversacion->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('conversacions.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('conversacions.edit', $conversacion->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Conversacion_usuario_envia</label>
<p>
	{{ $conversacion->conversacion_usuario_envia }}
</p> <label>Conversacion_usuario_recibe</label>
<p>
	{{ $conversacion->conversacion_usuario_recibe }}
</p> <label>Conversacion_fecha</label>
<p>
	{{ $conversacion->conversacion_fecha }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
