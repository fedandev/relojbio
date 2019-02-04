@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Lista de Menus</h5>
                </div>
				
				<div class="ibox-content">
				    <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('menus.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>
				    
					<div class="table-responsive">
                    
					    @if($menus->count())
    						<table class="footable table table-stripped " data-filter=#filter data-page="true">
    							<thead>
                                    <tr>
                                        <th data-hide="phone,tablet">Menu Padre</th>
                                        <th>Descripción</th>
                                        <th data-hide="phone,tablet">Posición</th>
                                        <th data-hide="phone,tablet">Habilitado</th>
                                        <th data-hide="phone,tablet">Url</th>
                                        <th data-hide="phone,tablet" >Icono</th>
                                        <th data-hide="phone,tablet" >Formulario</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
    							<tbody>
    								@foreach($menus as $menu)
    								  	@php 
    								  	    if($menu->menu_padre_id >0){
    								  	        $menu_padre = $menu->padre();     
    								  	    }else{
    								  	        $menu_padre = null;
    								  	    }
    								    @endphp
    								    
                                        <tr>
                                            @if ($menu_padre)
                                                <td><a href="{{ route('menus.show', $menu_padre->id ) }}" target="_blank">{{ $menu_padre->menu_descripcion }} </a> </td>
                                            @else
                                                <td> </td>
                                            @endif
                                           
                                            <td>{{$menu->menu_descripcion}}</td>
                                            <td>{{$menu->menu_posicion}}</td>
                                            <td>@if ($menu->menu_habilitado == 1)
                                                    <i class="fa fa-check text-navy"></i>
                                                @else
                                                    <i class="fa fa-times text-danger"></i>
                                                @endif
                                            </td>
                                            <td><a href="{{ $menu->menu_url }}" target="_blank">{{$menu->menu_url}}</a> </td>
                                            <td><i class="fa {{$menu->menu_icono}}"></i> </td>
                                            <td>{{$menu->menu_formulario}}</td>
                                            
                                            <td class="text-right">
                                              
                                                <a class="btn btn-xs btn-default" href="{{ route('menus.show', $menu->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('menus.edit', $menu->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
                                            
                                                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
        
                                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>
                                                </form>
                                          
        
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <ul class="pagination pull-left"></ul>
                                            </td>
                                        </tr>
                                    </tfoot>
    							</tbody>
    						</table>
                        @else
                            <h3 class="text-center alert alert-info">No hay datos para mostrar!</h3>
                        @endif
					</div>
                </div>
            </div>
        </div>
    </div>
 </div>
    
@endsection

