@extends('layouts.app')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Lista de Usuarios</h5>
					
				</div>
				
				<div class="ibox-content">
				     <div class="input-group">
				        <input type="text" class="form-control" id="filter"  placeholder="Buscar...">
				        <span class="input-group-btn">
				             <a class="btn btn-success" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Nuevo</a>
                        </span>
				    </div>


					<div class="table-responsive">
                    
					    @if($users->count())
    						<table class="footable table table-stripped " data-filter=#filter data-page="true">
    							<thead>
                                    <tr>
                                        <th>Email</th>
                                        <th data-hide="phone,tablet">Nombre</th> 
                                        <th data-hide="phone,tablet">Estado</th> 
                                        <th data-hide="phone,tablet">Observaciones</th> 
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
    							<tbody>
    								@foreach($users as $user)
    								   
                                        <tr>
                                           
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->nombre}}</td>
                                            <td>{{$user->estado}}</td>
                                            <td>{{$user->observaciones}}</td>
                                            
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-default" href="{{ route('users.show', $user->id) }}">
                                                    <i class="fa fa-eye"></i> 
                                                </a>
                                                
                                                <a class="btn btn-xs btn-default" href="{{ route('users.edit', $user->id) }}">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
        
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Esta seguro que desea eliminar?');" >
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


