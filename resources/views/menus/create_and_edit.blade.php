@extends('layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Menu /
                            @if($menu->id)
                                Editar #{{$menu->id}}
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
                        
                        @if($menu->id)
                            <form action="{{ route('menus.update', $menu->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('menus.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Menu Padre</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="menu_padre_id" id="menu_padre_id-field">
                                        @if($menus->count())
                                            <option value="0">Ninguno</option>
                                            @foreach($menus as $ax_menu)
                                                <option value="{{ $ax_menu->id }}"  
                                                    @if ($ax_menu->id == old('menu_padre_id', $menu->menu_padre_id ))
                                                        selected="selected"
                                                    @endif >
                                                    {{ $ax_menu->menu_descripcion}}
                                                </option>
                                               
                                            @endforeach
                                        @else
                                             <option value="0">No hay menu para seleccionar</option>
                                        @endif
                                        </select>
                                    </div>
                                    
                                    <label class="col-sm-1 control-label">Posición</label>
                                    <div class="col-sm-2"><input class="form-control" type="text" name="menu_posicion" id="menu_posicion-field" value="{{  $menu->menu_posicion  }}"></div>
                                
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="menu_descripcion" id="menu_descripcion-field" value="{{ old('menu_descripcion', $menu->menu_descripcion ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Habilitado </label>

                                    <div class="col-sm-10">
                                        <div class="i-checks">
                                            <label> 
                                                <input type="radio" name="menu_habilitado" id="menu_habilitado-field" value="1" {{ $menu->menu_habilitado == 1 ? 'checked' : '' }}>  Si 
                                            </label>
                                        </div>
                                        <div class="i-checks">
                                            <label> 
                                                <input type="radio" name="menu_habilitado" id="menu_habilitado-field" value="0" {{ $menu->menu_habilitado == 0 ? 'checked' : '' }}>   No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Url</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" type="text" name="menu_url" id="menu_url-field" value="{{ old('menu_url', $menu->menu_url ) }}">
                                    </div>
                                    
                                    <label class="col-sm-1 control-label">Icono</label>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="icono" id="id_icono" value="{{ old('menu_icono', $menu->menu_icono ) }}"/>
                                        <select class="form-control m-b" name="menu_icono" id="menu_icono-field">
                                            @include('layouts.icons')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Formulario</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="menu_formulario" id="menu_formulario-field" value="{{ old('menu_formulario', $menu->menu_formulario ) }}"></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                 
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('menus.index') }}"> Cancelar</a>
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

    <script type="text/javascript">
        $(document).ready(function() {
            var icono = $('#id_icono').val();
            $('#menu_icono-field option').each(function() {
                if($(this).val() ==  icono) {
                    $(this).prop("selected", true);
                }
            });
            $(".select2_demo_2").select2();
        });
    </script>
@endsection