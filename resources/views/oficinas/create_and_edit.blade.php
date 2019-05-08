@extends('layouts.app')

@section('styles')
<style type="text/css">
    .input-group {
      position: relative !important;
      display: flex !important;
    
      align-items: stretch !important;
      width: 100% !important;
    }
    
    .input-group-prepend{
        display: flex !important;
    }
    .input-group>.input-group-append:last-child>.btn:not(:last-child):not(.dropdown-toggle), .input-group>.input-group-append:last-child>.input-group-text:not(:last-child), .input-group>.input-group-append:not(:last-child)>.btn, .input-group>.input-group-append:not(:last-child)>.input-group-text, .input-group>.input-group-prepend>.btn, .input-group>.input-group-prepend>.input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .btn {
        margin-bottom: 0px !important;
    }
    
    #map {
        width: 100%;
        height: 400px;
        background-color: grey;
      }
</style>
@endsection

@section('content')

    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Oficina /
                            @if($oficina->id)
                                Editar #{{$oficina->id}}
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
      
                        @if($oficina->id)
                            <form action="{{ route('oficinas.update', $oficina->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('oficinas.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="oficina_nombre" id="oficina_nombre-field" value="{{ old('oficina_nombre', $oficina->oficina_nombre ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="oficina_descripcion" id="oficina_descripcion-field" value="{{ old('oficina_descripcion', $oficina->oficina_descripcion ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Código</label>
                                    <div class="col-sm-3"><input class="form-control" type="text" name="oficina_codigo" id="oficina_codigo-field" value="{{ old('oficina_codigo', $oficina->oficina_codigo ) }}"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Estado</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="oficina_estado" id="oficina_estado-field" value="{{ old('oficina_estado', $oficina->oficina_estado ) }}">
                                            <option value="1"> Activo</option>
                                            <option value="0"> Baja</option>
                                        </select>
                                    </div>
                                </div>
                             
                                <input type="hidden" name="oficina_latitud" id="oficina_latitud-field" value="{{ old('oficina_latitud', $oficina->oficina_latitud ) }}">
                                <input type="hidden" name="oficina_longitud" id="oficina_longitud-field" value="{{ old('oficina_longitud', $oficina->oficina_longitud ) }}">
                                <input type="hidden" name="latitud" id="latitud" value="{{ $latitud }}">
                                <input type="hidden" name="longitud" id="longitud" value="{{ $longitud }}">
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label">Ubicación</label>
                                    <div class="col-sm-6">
                                        <div class="input-group m-b">
                                            <span class="input-group-prepend" data-toggle="tooltip" data-placement="right" title="Click para abrir el mapa">
                                                <button type="button" class="btn btn-primary open_modal"> <i class="fa fa-map-marker"></i> </button>
                                            </span> 
                                            <input class="form-control" type="text" name="oficina_ubic" id="oficina_ubic-field" value="">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Sucursal</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_sucursal_id" id="fk_sucursal_id-field" value="{{ old('fk_sucursal_id', $oficina->fk_sucursal_id ) }}">
                                            @include('layouts.sucursales')
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Dispositivo</label>
                                    <div class="col-sm-3">
                                        <select class="select2_demo_2 form-control" name="fk_dispositivo_id" id="fk_dispositivo_id-field" value="{{ old('fk_dispositivo_id', $oficina->fk_dispositivo_id ) }}">
                                            @include('layouts.dispositivos')
                                        </select>
                                    </div>
                                </div>
                                
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('oficinas.index') }}"> Cancelar</a>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </div>
                                </div>
                                
                            </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>

     @include('layouts.mapa');       

@endsection


@section('scripts')
    
    <script>
        $(document).ready(function(){
            
            
            var sucursal_id = $("#fk_sucursal_id-field").attr('value');
            if(sucursal_id>0){
                $('#fk_sucursal_id-field option[value="'+ sucursal_id +'"]').prop("selected", true);
            }
            
            var dispositivo_id = $("#fk_dispositivo_id-field").attr('value');
            if(dispositivo_id>0){
                $('#fk_dispositivo_id-field option[value="'+ dispositivo_id +'"]').prop("selected", true);
            }
            
            $(".select2_demo_2").select2();
            
            //MODAL----

            $(document).on('click','.open_modal',function(){
            
                $('#myModal').modal('show');
                var latitud =  parseFloat($('#oficina_latitud-field').val());
                var longitud =  parseFloat($('#oficina_longitud-field').val());
                
                $('#marker_latitud').val(latitud);
                $('#marker_longitud').val(longitud);
                
                if(latitud){
                    var position = {lat: latitud, lng: longitud};
                }else{
                    var latitud  =  parseFloat($('#latitud').val());
                    var longitud =  parseFloat($('#longitud').val());
                    var position = {lat: latitud, lng: longitud};
                }
                
                placeMarker(position);
                $('#address-field').val("");
            });
        
            //update ***************************
            $("#btn-save").click(function (e) {
                searchAddress2();
            });
            
            $('#address-field').on('keypress', function (e) {
                if(e.which === 13){
                    searchCords();
                }
            });
            
            $("#btn_search").click(function (e) {
                searchCords();
            });
            
            var map ;
            var marker;
           
        });
        
        function initMap() {
            var latitud =  parseFloat($('#oficina_latitud-field').val());
            var longitud =  parseFloat($('#oficina_longitud-field').val());
            
            
            
            if(latitud){
                var position = {lat: latitud, lng: longitud};
            }else{
                var latitud  =  parseFloat($('#latitud').val());
                var longitud =  parseFloat($('#longitud').val());
                var position = {lat: latitud, lng: longitud};
                
            }
            alert(position);
            $('#marker_latitud').val(latitud);
            $('#marker_longitud').val(longitud);
            
            
            map = new google.maps.Map( document.getElementById('map'), {zoom: 12, center: position, mapTypeId: google.maps.MapTypeId.ROADMAP});
         
            google.maps.event.addListener(map, 'click', function(event) {
                    var coordenadas = event.latLng;
                    var lat = coordenadas.lat();
                    var lng = coordenadas.lng();
                    $('#marker_latitud').val(lat);
                    $('#marker_longitud').val(lng);
                    placeMarker(event.latLng);
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': event.latLng}, function(results, status) {
                         if (status == google.maps.GeocoderStatus.OK) {
                            var address=results[0]['formatted_address'];
                            $('#address-field').val(address); 
                            
                         }
                    });
            });
            
            searchAddress();
            
        }   
        
        function placeMarker(location) {
            if (!marker || !marker.setPosition) {
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });
                
            } else {
                marker.setPosition(location);
                map.setCenter(location); 
            }
         
        }
      
        function searchCords(){
            var geocoder = new google.maps.Geocoder();
            var address = $('#address-field').val();
           
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == 'OK') {
                    var lat = results[0].geometry.location.lat(function(a) { return a;});
                    var lng = results[0].geometry.location.lng(function(a) { return a;});
                    var position = results[0].geometry.location;
                    placeMarker(position);
                    $('#marker_latitud').val(lat);
                    $('#marker_longitud').val(lng);
                }
            });
            
        }
        
        function searchAddress(){
            var latitud =  parseFloat($('#marker_latitud').val());
            var longitud =  parseFloat($('#marker_longitud').val());
            if(latitud){
                var position = {lat: latitud, lng: longitud};
            }else{
                var latitud  =  parseFloat($('#latitud').val());
                var longitud =  parseFloat($('#longitud').val());
                var position = {lat: latitud, lng: longitud};
            }
         
          
            marker = new google.maps.Marker({position: position, map: map, draggable:true});
         
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': position}, function(results, status) {
                 if (status == google.maps.GeocoderStatus.OK) {
                    var address=results[0]['formatted_address'];
                    $('#oficina_ubic-field').val(address); 
                    
                 }
            });
            
        }
        
        function searchAddress2(){
            var latitud =  parseFloat($('#marker_latitud').val());
            var longitud =  parseFloat($('#marker_longitud').val());
            if(latitud){
                var position = {lat: latitud, lng: longitud};
            }else{
                var latitud  =  parseFloat($('#latitud').val());
                var longitud =  parseFloat($('#longitud').val());
                var position = {lat: latitud, lng: longitud};
            }
         
          
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                 if (status == google.maps.GeocoderStatus.OK) {
                    var address=results[0]['formatted_address'];
                    $('#oficina_ubic-field').val(address); 
                    $('#oficina_latitud-field').val($('#marker_latitud').val());
                    $('#oficina_longitud-field').val($('#marker_longitud').val());
                   
                    $('#myModal').modal('hide');
                 }
            });
            
        }
       
    </script>
    
    <script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTzG4eOmpvSSyO8RU_m37Py1LYjnKJYOo&callback=initMap">  </script>
    
@endsection