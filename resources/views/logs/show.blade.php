@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Log / Show #{{ $log->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('logs.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('logs.edit', $log->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Log_fecha</label>
<p>
	{{ $log->log_fecha }}
</p> <label>Log_accion</label>
<p>
	{{ $log->log_accion }}
</p> <label>Log_tabla</label>
<p>
	{{ $log->log_tabla }}
</p> <label>Log_parametro</label>
<p>
	{{ $log->log_parametro }}
</p> <label>Log_otros</label>
<p>
	{{ $log->log_otros }}
</p> <label>Fk_usuario_id</label>
<p>
	{{ $log->fk_usuario_id }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection
