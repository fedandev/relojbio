@extends('layouts.app')

@section('content')
<?php 
use App\Http\Controllers\MensajesController ;
use App\Models\Conversacion;
use App\Models\Mensaje;
use App\User;
?>
<?php $conversaciones = Conversacion::where('conversacion_usuario_recibe',auth()->user()->id)->get();
$mensaje=0;
?>
 
@foreach($conversaciones as $conversacion)
    <?php $mensaje += Mensaje::where('fk_conversacion_id',$conversacion->id)->where('mensaje_usuario_envia','!=',auth()->user()->id)->where('mensaje_leido','=','0')->count();?>
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
                                <li><a href="{{ route('conversacions.index') }}"> <i class="fa fa-inbox "></i> Bandeja de Entrada <span class="label label-warning pull-right">{{$mensaje}}</span> </a></li>
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
                        <form action="{{ route('mensajes.store') }}" class="form-horizontal" name="form" id="form" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="mensaje_fecha" id="mensaje_fecha" value="<?php echo date("Y-m-d h:i:s");  ?>">
                            <input type="hidden" name="mensaje_usuario_envia" id="mensaje_usuario_envia" value="<?php echo auth()->user()->id;?>">
                            <input type="hidden" name="fk_conversacion_id" id="fk_conversacion_id" value="">
                            <textarea name="mensaje_mensaje" id="mensaje_mensaje" style="display:none;"/> </textarea>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">Para:</label>
                                <div class="col-sm-10">
                                    <select class="select2_demo_2 form-control" name="usuario" id="usuario">
                                        @include('layouts.usuarios');
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">Título</label>
                                <div class="col-sm-10"><input class="form-control" type="text" name="mensaje_titulo" id="mensaje_titulo-field"></div>
                            </div>
                        </form>
                    </div>
                    <div class="mail-text h-200">
                        <div class="summernote" id="mensaje" name="mensaje">
                            
                        </div>
                        <h4 id="maxContentPost" style="text-align:right">400</h4>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mail-body text-right tooltip-demo">
                        <button onclick="Enviar()" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Enviar" ><i class="fa fa-reply"></i> Enviar</button>
                        <a href="{{ route('conversacions.index') }}" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Descartar"><i class="fa fa-times"></i> Descartar</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script>
    $(document).ready(function(){
        $(".select2_demo_2").select2();
        //$('.summernote').summernote();
        
        $('.summernote').summernote({
            height: 250,
            callbacks: {
                onKeydown: function (e) { 
                    var t = e.currentTarget.innerText; 
                    if (t.trim().length >= 400) {
                        //delete key
                        if (e.keyCode != 8)
                        e.preventDefault(); 
                    } 
                },
                onKeyup: function (e) {
                    var t = e.currentTarget.innerText;
                    $('#maxContentPost').text(400 - t.trim().length);
                },
                onPaste: function (e) {
                    var t = e.currentTarget.innerText;
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    var all = t + bufferText;
                    document.execCommand('insertText', false, all.trim().substring(0, 400));
                    $('#maxContentPost').text(400 - t.length);
                }
            }
        });
    });
    
    
    function Enviar(){
        var mensaje = $("#mensaje").summernote('code');
        document.getElementById('mensaje_mensaje').value = mensaje;
        document.getElementById("form").submit();
    }
    
</script>


@endsection
