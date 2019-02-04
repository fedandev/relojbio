@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Log /
                    @if($log->id)
                        Edit #{{$log->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($log->id)
                    <form action="{{ route('logs.update', $log->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('logs.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="log_fecha-field">Log_fecha</label>
                	<input class="form-control" type="text" name="log_fecha" id="log_fecha-field" value="{{ old('log_fecha', $log->log_fecha ) }}" />
                </div> 
                <div class="form-group">
                	<label for="log_accion-field">Log_accion</label>
                	<input class="form-control" type="text" name="log_accion" id="log_accion-field" value="{{ old('log_accion', $log->log_accion ) }}" />
                </div> 
                <div class="form-group">
                	<label for="log_tabla-field">Log_tabla</label>
                	<input class="form-control" type="text" name="log_tabla" id="log_tabla-field" value="{{ old('log_tabla', $log->log_tabla ) }}" />
                </div> 
                <div class="form-group">
                	<label for="log_parametro-field">Log_parametro</label>
                	<input class="form-control" type="text" name="log_parametro" id="log_parametro-field" value="{{ old('log_parametro', $log->log_parametro ) }}" />
                </div> 
                <div class="form-group">
                	<label for="log_otros-field">Log_otros</label>
                	<input class="form-control" type="text" name="log_otros" id="log_otros-field" value="{{ old('log_otros', $log->log_otros ) }}" />
                </div> 
                <div class="form-group">
                    <label for="fk_usuario_id-field">Fk_usuario_id</label>
                    <input class="form-control" type="text" name="fk_usuario_id" id="fk_usuario_id-field" value="{{ old('fk_usuario_id', $log->fk_usuario_id ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('logs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection