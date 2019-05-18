@extends('layouts.app')

@section('content')
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
    			<div class="ibox-title">
    				<h5>Registrar Marca</h5>
                </div>
    			
    			<div class="ibox-content">
    			    <form action="{{ route('marcaempleado.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal" id="formMarca">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="latitud" id="latitud" value="{{ $latitud }}">
                        <input type="hidden" name="longitud" id="longitud" value="{{ $longitud }}">
                        <input type="hidden" name="latitudNow" id="latitudNow" >
                        <input type="hidden" name="longitudNow" id="longitudNow">
                        <input type="hidden" name="distancia" id="distancia">
                        <input type="hidden" id="imageData" name="imageData" />
                        
                        <span id="liveclock"></span>
                        
                        <div class='col-lg-3'>
                            <div class='widget style1 navy-bg'>
                                <div class='row'>
                                    <div class='col-sm-4 text-center'>
                                        <i class='fa fa-clock-o fa-4x'></i>
                                    </div>
                                    <div class='col-sm-6 text-center'>
                                        <span id="liveclock2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <video id="player" controls autoplay></video>
                        <canvas id="snapshot" width=320 height=420 style="display:none;"></canvas>
                        
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit" >Marcar</button>
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

<script language="JavaScript" type="text/javascript">
    var player = document.getElementById('player');
    var snapshotCanvas = document.getElementById('snapshot');
    var captureButton = document.getElementById('boton');
    
    var handleSuccess = function(stream) {
    // Attach the video stream to the video element and autoplay.
    player.srcObject = stream;
    };
    
    
    
    navigator.mediaDevices.getUserMedia({video: true})
      .then(handleSuccess);

    function show5(){
        if (!document.layers&&!document.all&&!document.getElementById)
        return

         var Digital=new Date()
         var hours=Digital.getHours()
         var minutes=Digital.getMinutes()
         var seconds=Digital.getSeconds()

         if (minutes<=9)
         minutes="0"+minutes
         if (seconds<=9)
         seconds="0"+seconds
        //change font size here to your desire
        myclock="<input type='hidden' id='hora' name='hora' value='"+hours+":"+minutes+":"
         +seconds+"' readonly></input>";
        myclock2= "<h2 class='font-bold'>"+hours+":"+minutes+":"+seconds+"</h2>";
         
        if (document.layers){
        document.layers.liveclock.document.write(myclock)
        document.layers.liveclock.document.close()
        }
        else if (document.all)
        liveclock.innerHTML=myclock
        else if (document.getElementById)
        document.getElementById("liveclock").innerHTML=myclock
        document.getElementById("liveclock2").innerHTML=myclock2
        setTimeout("show5()",1000)
        var startPos;
       
        var geoSuccess = function(position) {
            startPos = position;
            document.getElementById('latitudNow').value = startPos.coords.latitude;
            document.getElementById('longitudNow').value = startPos.coords.longitude;
        };
       
        
        navigator.geolocation.getCurrentPosition(geoSuccess);
    }

    window.onload=show5
     //-->
    
    function Dist(lat1, lon1, lat2, lon2) {
         rad = function (x) {
             return x * Math.PI / 180;
         }
     
         var R = 6378.137;//Radio de la tierra en km
         var dLat = rad(lat2 - lat1);
         var dLong = rad(lon2 - lon1);
         var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
         var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
         var d = R * c;
         return d.toFixed(3);//Retorna tres decimales
    }
    
    $(document).ready(function(){
        
        $('#formMarca').on('submit', function(e){
            var context = snapshot.getContext('2d');
            // Draw the video frame to the canvas.
            context.drawImage(player, 0, 0, snapshotCanvas.width, snapshotCanvas.height);
            var imageDataUrl = snapshotCanvas.toDataURL();
            
            e.preventDefault();
            // latFija = document.getElementById('latitud').value;
            // lonFija =document.getElementById('longitud').value;
            // distancia = Dist(document.getElementById('latitudNow').value,document.getElementById('longitudNow').value,latFija, lonFija );    
            // document.getElementById('distancia').value = distancia;
            document.getElementById('imageData').value = imageDataUrl;
            this.submit();
            
        });
    });
    
 </script>
 
@endsection