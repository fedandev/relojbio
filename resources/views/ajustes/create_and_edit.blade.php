@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Ajustes /
                            @if($ajuste->id)
                                Editar #{{$ajuste->id}}
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
                        
                        @if($ajuste->id)
                            <form action="{{ route('ajustes.update', $ajuste->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('ajustes.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="ajuste_nombre" id="ajuste_nombre-field" value="{{ old('ajuste_nombre', $ajuste->ajuste_nombre ) }}"></div>
                                </div>
                                
                             
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Valor</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="ajuste_valor" id="ajuste_valor-field" value="{{ old('ajuste_valor', $ajuste->ajuste_valor ) }}"></div>
                                </div>

                               
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción </label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="ajuste_descripcion" id="ajuste_descripcion-field" value="{{ old('ajuste_descripcion', $ajuste->ajuste_descripcion ) }}"></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('ajustes.index') }}"> Cancelar</a>
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


