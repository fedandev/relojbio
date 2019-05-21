<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element" style="text-align: center;">
                    <span>
                        <img alt="image" class="img-md" style="" src="{{ asset('images/avatar.png') }}" />
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ auth()->user()->nombre }}</strong>
                            </span> <span class="text-muted text-xs block">Perfil <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                             <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); localStorage.clear();">Logout</a>
                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    <h5>SGRRHH</h5>
                </div>
            </li>
         
            @foreach(auth()->user()->MenusHabilitados() as $menu)
                @php 
                    $route = $menu->menu_formulario.'.index'; 
                    $hijos =  $menu->menus_hijos();
                @endphp
                
                @if($menu->menu_padre_id == 0 and $hijos->count()== 0) <!-- si no tiene menu hijos -->
                    <li class="{{ isActiveRoute($route) }}">
                        <a href="{{ $menu->menu_url }}"><i class="fa {{ $menu->menu_icono }}"></i> <span class="nav-label">{{ $menu->menu_descripcion }}</span></a>
                    </li>
                @else
                    
                    @if($hijos->count()>0)
                        <li>
                            <a><i class="fa {{ $menu->menu_icono }}"></i> <span class="nav-label">{{ $menu->menu_descripcion }}</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                 
                                
                                @foreach($hijos as $hijo)
                                
                                    @php 
                                        $route = $hijo->menu_formulario.'.index';
                                    @endphp   
                                    <li class='{{ isActiveRoute($route) }}'>
                                        <a href='{{ $hijo->menu_url }}'><i class='fa {{ $hijo->menu_icono }}'></i> {{ $hijo->menu_descripcion }} </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                
                @endif
            
            @endforeach
            
         
        </ul>


       
    </div>
</nav>
