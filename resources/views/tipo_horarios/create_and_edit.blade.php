@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Tipo Horario /
                            @if($tipo_horario->id)
                                Editar #{{$tipo_horario->tipohorario_nombre}}
                            @else
                                Nuevo
                            @endif
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    
                    
                    
                    <div class="ibox-content">
                        @include('common.error')
                        
                        @if($tipo_horario->id)
                            <form action="{{ route('tipo_horarios.update', $tipo_horario->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('tipo_horarios.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="tipohorario_nombre" id="tipohorario_nombre-field" value="{{ old('tipohorario_nombre', $tipo_horario->tipohorario_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="tipohorario_descripcion" id="tipohorario_descripcion-field" value="{{ old('tipohorario_descripcion', $tipo_horario->tipohorario_descripcion ) }}"></div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                 
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('tipo_horarios.index') }}"> Cancelar</a>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </div>
                                </div>
                            </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>

            

@endsection
