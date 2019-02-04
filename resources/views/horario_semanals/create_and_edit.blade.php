@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Horarios Semanales /
                            @if($horario_semanal->id)
                                Editar #{{$horario_semanal->id}}
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
                        
                        @if($horario_semanal->id)
                            <form action="{{ route('horario_semanals.update', $horario_semanal->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('horario_semanals.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="horariosemanal_nombre" id="horariosemanal_nombre-field" value="{{ old('horariosemanal_nombre', $horario_semanal->horariosemanal_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Horas a realizar </label>
                                    <div class="col-sm-3"><input class="form-control mask-time" type="text"  data-mask="99:99"name="horariosemanal_horas" id="horariosemanal_horas-field" value="{{ old('horariosemanal_horas', $horario_semanal->horariosemanal_horas ) }}"></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('horario_semanals.index') }}"> Cancelar</a>
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

@section('scripts')

    <scripts>
        $(document).ready(function() {        
            $('.mask-time').inputmask({
              mask: '99:59'
            });
         });
    </scripts>
@endsection