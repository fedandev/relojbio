@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> <i class="fa fa-cloud-upload"></i> Cargar registros desde archivo</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                   
                        <form method="POST" action="{{ route('registros.loadExcel') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal">
                            {{csrf_field()}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" id="archivo" name="archivo" required >
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('registros.index') }}"> Cancelar</a>
                                    <button class="btn btn-primary" type="submit">Enviar</button>
                                </div>
                            </div>
                            
                        </form>
                    
                </div>
            </div>
        </div>
    </div>
 </div>
    
@endsection


