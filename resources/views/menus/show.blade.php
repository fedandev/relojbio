@extends('layouts.app')

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Menu / Ver "{{$menu->menu_descripcion}}"
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                   
                    
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Menu Padre</label>
                                <div class="col-lg-2">
                                    @if ($menu->menu_padre_id)
                                        <p class="form-control-static">{{  $menu->padre()->menu_descripcion }} </p>
                                    @endif
                                </div>
                            
                                <label class="col-lg-2 control-label">Posición</label>
                                <div class="col-lg-2">
                                    <p class="form-control-static">{{  $menu->menu_posicion }} </p>
                                </div>
                                
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Descripción</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $menu->menu_descripcion }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Habilitado</label>
                                <div class="col-lg-10">
                                        <p class="form-control-static">
                                            @if ($menu->menu_habilitado == 1)
                                                Si
                                            @else
                                                No
                                            @endif
                                        
                                        </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Url</label>
                                <div class="col-lg-2">
                                    <p class="form-control-static">{{  $menu->menu_url }} </p>
                                </div>
                                
                                
                                <label class="col-lg-2 control-label">Icono</label>
                                <div class="col-lg-2">
                                    <p class="form-control-static"><i class="fa {{  $menu->menu_icono }}"></i> </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                             
                           
                            <div class="form-group"><label class="col-lg-2 control-label">Formulario</label>
                                <div class="col-lg-10"><p class="form-control-static">{{  $menu->menu_formulario }} </p></div>
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('menus.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('menus.edit', $menu->id) }}">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>


@endsection
