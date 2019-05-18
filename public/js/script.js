/*
    Tomar una fotografía y guardarla en un archivo
    @date 2017-11-22
    @author parzibyte
    @web parzibyte.me/blog
*/
function tieneSoporteUserMedia() {
    return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
}
function _getUserMedia() {
    return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
}

// Declaramos elementos del DOM
var $video = document.getElementById("video"),
	$canvas = document.getElementById("canvas"),
	$boton = document.getElementById("boton"),
	$estado = document.getElementById("estado");
if (tieneSoporteUserMedia()) {
    _getUserMedia(
        {video: true},
        function (stream) {
            console.log("Permiso concedido");
            
				
			$video.srcObject = stream;
			$video.play();

			//Escuchar el click
			$boton.addEventListener("click", function(){

				//Pausar reproducción
				$video.pause();

				//Obtener contexto del canvas y dibujar sobre él
				var contexto = $canvas.getContext("2d");
				$canvas.width = $video.videoWidth;
				$canvas.height = $video.videoHeight;
				contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

				var foto = $canvas.toDataURL(); //Esta es la foto, en base 64
				
				$estado.innerHTML = "Enviando foto. Por favor, espera...";
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "./marcaempleado/guardar", true);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send(encodeURIComponent(foto)); //Codificar y enviar
				console.log(foto);
				xhr.onreadystatechange = function() {
				    if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
				        console.log("La foto fue enviada correctamente");
				        console.log(xhr);
				        $estado.innerHTML = "Foto guardada con éxito. Puedes verla <a target='_blank' href='./" + xhr.responseText + "'> aquí</a>";
				    }
				}

				//Reanudar reproducción
				$video.play();
			});
        }, function (error) {
            console.log("Permiso denegado o error: ", error);
            $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
        });
} else {
    alert("Lo siento. Tu navegador no soporta esta característica");
    $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
}