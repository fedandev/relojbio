@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Conversacion /
                    @if($conversacion->id)
                        Edit #{{$conversacion->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($conversacion->id)
                    <form action="{{ route('conversacions.update', $conversacion->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('conversacions.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                    <label for="conversacion_usuario_envia-field">Conversacion_usuario_envia</label>
                    <input class="form-control" type="text" name="conversacion_usuario_envia" id="conversacion_usuario_envia-field" value="{{ old('conversacion_usuario_envia', $conversacion->conversacion_usuario_envia ) }}" />
                </div> 
                <div class="form-group">
                    <label for="conversacion_usuario_recibe-field">Conversacion_usuario_recibe</label>
                    <input class="form-control" type="text" name="conversacion_usuario_recibe" id="conversacion_usuario_recibe-field" value="{{ old('conversacion_usuario_recibe', $conversacion->conversacion_usuario_recibe ) }}" />
                </div> 
                <div class="form-group">
                    <label for="conversacion_fecha-field">Conversacion_fecha</label>
                    <input class="form-control" type="text" name="conversacion_fecha" id="conversacion_fecha-field" value="{{ old('conversacion_fecha', $conversacion->conversacion_fecha ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('conversacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection