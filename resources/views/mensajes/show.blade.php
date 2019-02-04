@extends('layouts.app')

@section('content')
<?php 
use App\Http\Controllers\MensajesController ;
use App\Models\Conversacion;
use App\Models\Mensaje;
use App\User;
?>
<?php $conversaciones = Conversacion::where('conversacion_usuario_recibe',auth()->user()->id)->get();
$mensajes=0;
?>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
@foreach($conversaciones as $conversacion)
    <?php $mensajes += Mensaje::where('fk_conversacion_id',$conversacion->id)->where('mensaje_usuario_envia','!=',auth()->user()->id)->where('mensaje_leido','=','0')->count();?>
@endforeach
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <a class="btn btn-block btn-primary compose-mail" href="{{ route('mensajes.create') }}">Crear Mensaje</a>
                        <div class="space-25"></div>
                        <h5>Carpetas</h5>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><a href="{{ route('conversacions.index') }}"> <i class="fa fa-inbox "></i> Chats <span class="label label-warning pull-right">{{$mensajes}}</span> </a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    <a href="{{ route('conversacions.index') }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Descartar correo"><i class="fa fa-times"></i> Descartar</a>
                </div>
                <h2>
                    Crear Correo
                </h2>
            </div>
                <div class="mail-box">
                    <div class="mail-body">
                        <form action="{{ route('mensajes.store') }}" class="form-horizontal" method="POST">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">Envia:</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $mensaje->usuario->nombre }} </p></div>
                            </div>
                            <div class="mail-text h-200">
                                <div class="summernote">
                                    {!! $mensaje->mensaje_mensaje !!}
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>
                            <div class="mail-body text-right tooltip-demo">
                            
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.summernote').summernote({
            height: 250,
            'disable'
        });
    });
</script>

<script >
     $(document).ready(function() {
        $(".select2_demo_2").select2();
    });
</script>
@endsection
