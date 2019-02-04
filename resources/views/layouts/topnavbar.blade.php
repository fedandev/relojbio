<?php
use App\Models\Conversacion;
use App\Models\Mensaje;
use App\User;
?>
<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">                                                                       <!-- MENSAJES -->
                <?php 
                $entre = 0;
                $conversaciones = Conversacion::where('conversacion_usuario_recibe',auth()->user()->id)->orWhere('conversacion_usuario_envia',auth()->user()->id)->get();
                $mensaje=0;
                ?>
                @foreach($conversaciones as $conversacion)
                    <?php $mensaje += Mensaje::where('fk_conversacion_id',$conversacion->id)->where('mensaje_usuario_envia','!=',auth()->user()->id)->where('mensaje_leido','=','0')->count();?>
                @endforeach
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">{{$mensaje}}</span>     <!-- CANTIDAD DE MENSAJES SIN LEER -->
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <?php $conversaciones = Conversacion::where('conversacion_usuario_recibe',auth()->user()->id)->orWhere('conversacion_usuario_envia',auth()->user()->id)->get();?>
                        @foreach($conversaciones as $conversacion)
                            <?php 
                            $usuario = User::where('id',$conversacion->conversacion_usuario_envia)->get();
                            $mensaje = Mensaje::where('fk_conversacion_id',$conversacion->id)->where('mensaje_leido','=','0')->where('mensaje_usuario_envia','!=',auth()->user()->id)->orderBy('id','desc')->get();
                            ?>
                            @if($mensaje->isEmpty())
                            @else
                                <?php $entre=1; ?>
                                <li>
                                    <div class="dropdown-messages-box">    
                                        <a href="{{ route('conversacions.index') }}" class="pull-left">
                                            <img alt="image" class="img-circle" src="{{ asset('images/user48x48.png') }}">               <!-- IMAGEN DEL QUE MANDA -->   
                                        </a>
                                        <div class="media-body">
                                            <strong>{{$usuario[0]->nombre}}</strong><br>
                                            <small class="text-muted">{{$mensaje[0]->mensaje_fecha}}</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                            @endif
                        @endforeach
                        @if($entre==0)
                            <li>
                                <div class="dropdown-messages-box">    
                                    <a href="{{ route('conversacions.index') }}" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{ asset('images/user48x48.png') }}">               <!-- IMAGEN DEL QUE MANDA -->   
                                    </a>
                                    <div class="media-body">
                                        <strong></strong><br>
                                        <small class="text-muted">{{ "No hay mensajes nuevos" }}</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                        @endif
                        <li>
                            <div class="text-center link-block">
                                <a href="{{ route('conversacions.index') }}">                 <!-- RUTA -->
                                    <i class="fa fa-envelope"></i> <strong>Leer todos los mensajes</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- <li class="dropdown">                                                                 <!--      NOTIFICACION
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>             <!--  CANTIDAD DE NOTIFICACIONES SIN LEER
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">                                                         <!-- URL
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages               <!-- ICONO Y TITULO 
                                    <span class="pull-right text-muted small">4 minutes ago</span>          <!-- TIEMPO DESDE QUE SE ENVIO 
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">                                               <!-- URL DE LA BANDEJA DE NOTIFICACIONES 
                                    <strong>Ver todas las alertas</strong>                                  <!-- CANTIDAD DE NOTIFICACIONES 
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> -->
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); localStorage.clear();">
                    <i class="fa fa-sign-out"></i> Salir
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </a>
            </li>
        </ul>
    </nav>
</div>
