<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <title>{{ ajuste('system_name') }} 
            @if (routeIndex($controller) != 'home') 
                | {{ trans('controllers.'.$controller) }}
            @else
                | Inicio
            @endif     
            @if ($action != 'index' and $action != 'showLoginForm')
                | {{ trans('generic.'.$action) }}
            @endif
    </title>

    <!-- Styles -->

    @include('layouts.styles')
   
    @section('styles')
    @show   
</head>

    @guest
        @yield('content')
        
    @else
        <body class="">
          <!-- Wrapper-->
            <div id="wrapper">
        
                <!-- Navigation -->
                @include('layouts.navigation')
        
                <!-- Page wraper -->
                <div id="page-wrapper" class="gray-bg">
        
                    <!-- Page wrapper -->
                    @include('layouts.topnavbar')
                    
                    
                    @include('layouts.headerpanel')
                    
                    <!-- Main view  -->
                    @include('common.msg')
                    @yield('content')
        
                    <!-- Footer -->
                    @include('layouts.footer')
        
                </div>
                <!-- End page wrapper-->
        
            </div>
            <!-- End wrapper-->
            
            
            
            <!-- Scripts -->
            @include('layouts.scripts')
               
            
            @section('scripts')
            @show
        </body>
    @endguest


</html>
