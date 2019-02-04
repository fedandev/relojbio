@extends('layouts.app')

@section('content')
<?php 
use App\Http\Controllers\ConversacionsController ;
use App\Models\Conversacion;
use App\Models\Mensaje;
use App\User;
?>
<?php 
    $conversaciones = Conversacion::where('conversacion_usuario_recibe',auth()->user()->id)->get();
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
                            <li><a href="{{ route('conversacions.index') }}"> <i class="fa fa-inbox "></i> Bandeja Entrada<span class="label label-warning pull-right">{{$mensaje}}</span> </a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
        <div class="mail-box-header">

            <div class="pull-right mail-search">
                <div class="input-group">
                    <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
                    <div class="input-group-btn">
                    </div>
                </div>
            </div>
            <h2>
                Mensajes ({{$mensaje}})
            </h2>
            <div class="mail-tools tooltip-demo m-t-md">
                <div class="btn-group pull-right">
                    <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                    <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>

                </div>
                <span class="btn btn-white btn-sm" data-action="refresh" data-toggle="tooltip" data-placement="left" title="Refrescar"><i class="fa fa-refresh"></i> Recargar</span>
            </div>
        </div>
            <div class="mail-box">
                <table class="table table-hover table-mail" data-page-size="8" data-filter=#filter >
                    <tbody>
                        <?php $conversaciones = Conversacion::where('conversacion_usuario_recibe',auth()->user()->id)->orWhere('conversacion_usuario_envia',auth()->user()->id)->get();?>
                        @foreach($conversaciones as $conversacion)
                            <?php 
                                $usuario = User::where('id',$conversacion->conversacion_usuario_envia)->get();
                                $mensajes = Mensaje::where('fk_conversacion_id',$conversacion->id)->where('mensaje_usuario_envia','!=',auth()->user()->id)->orderBy('id','desc')->get();
                            ?>
                            @foreach($mensajes as $mensaje)
                                @if($mensaje->mensaje_leido == 1)
                                    <tr class="read">
                                @else
                                    <tr class="unread">
                                @endif
                                        <td class="mail-ontact"><a href="{{ route('mensajes.show', $mensaje->id) }}">{{$usuario[0]->nombre}}</a></td>
                                        <td class="mail-subject"><a href="{{ route('mensajes.show', $mensaje->id) }}">{{ strip_tags($mensaje->mensaje_titulo) }}</a></td>
                                        <td class="text-right mail-date">{{$mensaje->mensaje_fecha}}</td>
                                        <td class="text-right">
                                            <form action="{{ route('conversacions.destroy', $conversacion->id) }}" method="POST" style="display: inline;" id="frmDelete">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-white btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash-o"></i> </button>
                                            </form>
                                        </div>
                                    </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection