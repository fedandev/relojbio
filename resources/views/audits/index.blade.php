@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Auditoria</h5>
                    </div>
                    <div class="ibox-content">
                        @include('common.error')
                        <form action="{{ route('audits.search') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                            <div class="form-group" id="data_5">
                                <label class="col-sm-2 control-label">Rango de Fecha</label>
                                <div class="input-daterange input-group" id="datepicker" style="padding-left: 16px;">
                                    <input type="text" class="input-sm form-control" name="date_start" value=""/>
                                    <span class="input-group-addon">a</span>
                                    <input type="text" class="input-sm form-control" name="date_end" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Usuario</label>
                                <div class="col-sm-3">
                                    <select class="select2_demo_1 form-control" name="user_id" id="user_id-field" required>
                                        @include('layouts.usuarios')
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Controlador</label>
                                <div class="col-sm-3">
                                    <select class="select2_demo_2 form-control" multiple="multiple" name="auditable_type[]" id="auditable_type-field">
                                        @include('layouts.auditabletype')
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('audits.index') }}"> Cancelar</a>
                                    <button class="btn btn-primary" type="submit">Buscar</button>
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
        $('#data_5 .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
    });
    
    $(".select2_demo_1").select2({
        placeholder: "Seleccione un empleado",
        allowClear: true
    });
    $(".select2_demo_2").select2();
</script>

@endsection