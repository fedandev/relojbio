<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
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
    
    <link rel="manifest" href="{{ secure_asset('manifest.json') }} ">
    
     <!-- IOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <link rel="apple-touch-icon" href="{{ secure_asset('images/icons/icon-64x64.png') }}">
    
    <meta name="apple-mobile-web-app-title" content="{{ ajuste('system_name') }}">

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