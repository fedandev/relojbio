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
                            <i class="fa fa-edit"></i> Oficina / Ver "{{$oficina->oficina_nombre}}"
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
                                <label class="col-lg-2 control-label">Nombre</label>
                                <div class="col-lg-6"><p class="form-control-static">{{  $oficina->oficina_nombre }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Descripcion</label>
                                <div class="col-lg-6"><p class="form-control-static">{{  $oficina->oficina_descripcion }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-lg-2 control-label">Código</label>
                                <div class="col-lg-6"><p class="form-control-static">{{  $oficina->oficina_codigo }} </p></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                           
                            <div class="form-group"><label class="col-lg-2 control-label">Estado</label>
                                <div class="col-lg-3">
                                        <p class="form-control-static">
                                            @if ($oficina->oficina_estado == 1)
                                                Activo
                                            @else
                                                Baja
                                            @endif
                                        
                                        </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            
                            <input type="hidden" name="oficina_latitud" id="oficina_latitud-field" value="{{ $oficina->oficina_latitud  }}">
                            <input type="hidden" name="oficina_longitud" id="oficina_longitud-field" value="{{  $oficina->oficina_longitud }}">
                            
                            <div class="form-group ">
                                <label class="col-sm-2 control-label">Ubicación</label>
                                <div class="col-sm-6">
                                    <p class="form-control-static">
                                        <a id="ubicacion" class="open_modal">
                                            
                                        </a>
                                    </p>
                                </div>
                            </div>
                                
                            <div class="hr-line-dashed"></div>
                            
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Sucursal</label>
                               
                                <div class="col-lg-3">
                                    <p class="form-control-static">
                                        <a href="{{ route('dispositivos.show', $oficina->sucursal->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                            {{  $oficina->sucursal->sucursal_nombre }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Dispositivo</label>
                                <div class="col-lg-3">
                                    <p class="form-control-static">
                                        <a href="{{ route('dispositivos.show', $oficina->dispositivo->id) }}" target="_blank" data-toggle="tooltip" data-placement="right" title="Click para abrir en nueva pestaña">
                                            {{  $oficina->dispositivo->dispositivo_nombre }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                           
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a class="btn btn-white" href="{{ route('oficinas.index') }}"> <i class="fa fa-backward"></i> Volver</a>
                                   
                                    <a class="btn btn-default" href="{{ route('oficinas.edit', $oficina->id) }}">
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

    @include('layouts.mapa');

@endsection



@section('scripts')
    
    <script>
        $(document).ready(function(){
            
                    //MODAL----

            $(document).on('click','.open_modal',function(){
            
                $('#myModal').modal('show');
            });
        
          
            $("#btn-save").hide();
            $("#divSearch").hide();
 
            var map ;
           
           
        });
        
        function initMap() {
            var latitud =  parseFloat($('#oficina_latitud-field').val());
            var longitud =  parseFloat($('#oficina_longitud-field').val());
            if(latitud != 0){
                var position = {lat: latitud, lng: longitud};
            }else{
                var position = {lat: -33.4368194, lng: -70.5631095};
            }
            map = new google.maps.Map( document.getElementById('map'), {zoom: 12, center: position, mapTypeId: google.maps.MapTypeId.ROADMAP});
         
            var marker = new google.maps.Marker({
                position: position,
                map: map,
            });
            
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': position}, function(results, status) {
                 if (status == google.maps.GeocoderStatus.OK) {
                    var address=results[0]['formatted_address'];
                    $('#ubicacion').html(" "+ address); 
                    
                 }
            });
            
        }   
        
       
       
    </script>
    
    <script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTzG4eOmpvSSyO8RU_m37Py1LYjnKJYOo&callback=initMap">  </script>
    
@endsection