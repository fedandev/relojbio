@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Turno Rotativo /
                            @if($horario_rotativo->id)
                                Editar #{{$horario_rotativo->id}}
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
                        
                        @if($horario_rotativo->id)
                            <form action="{{ route('horario_rotativos.update', $horario_rotativo->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('horario_rotativos.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="horariorotativo_nombre" id="horariorotativo_nombre-field" value="{{ old('horariorotativo_nombre', $horario_rotativo->horariorotativo_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Día Comienzo</label>
                                    <div class="col-sm-2">
                                        <select class="select2_demo_2 form-control" name="horariorotativo_diacomienzo" id="horariorotativo_diacomienzo-field" value="{{ old('horariorotativo_diacomienzo', $horario_rotativo->horariorotativo_diacomienzo ) }}">
                                            @include('layouts.dias')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Días de Trabajo </label>
                                    <div class="col-sm-2"><input class="form-control" type="number" name="horariorotativo_diastrabajo" id="horariorotativo_diastrabajo-field" value="{{ old('horariorotativo_diastrabajo', $horario_rotativo->horariorotativo_diastrabajo ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Días Libres </label>
                                    <div class="col-sm-2"><input class="form-control" type="number" name="horariorotativo_diaslibres" id="horariorotativo_diaslibres-field" value="{{ old('horariorotativo_diaslibres', $horario_rotativo->horariorotativo_diaslibres ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Horario</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_horario_id" id="fk_horario_id-field" value="{{ old('fk_horario_id', $horario_rotativo->fk_horario_id ) }}">
                                            @include('layouts.horarios')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('horario_rotativos.index') }}"> Cancelar</a>
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

    <script>
        $(document).ready(function(){
            
            
            var horario_id = $("#fk_horario_id-field").attr('value');
            if(horario_id>0){
                $('#fk_horario_id-field option[value="'+ horario_id +'"]').prop("selected", true);
            }
            
            $(".select2_demo_2").select2();
        
        });
                  
    </script>
    
@endsection