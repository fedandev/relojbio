<script src="{{ secure_asset('js/plugins/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/jquery.metisMenu.js') }}" type="text/javascript"></script>  <!-- menu desplegable en navbar -->
<script src="{{ secure_asset('js/plugins/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/footable.all.min.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/inspinia.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/select2.full.min.js') }}" type="text/javascript"></script>
<!--<script src="{{ asset('js/plugins/select2.full.min.js') }}" type="text/javascript"></script>-->
<script src="{{ secure_asset('js/plugins/toastr.min.js') }}" type="text/javascript"></script>
<!--<script src="{{ asset('js/plugins/sweetalert.min.js') }}" type="text/javascript"></script>-->
<script src="{{ secure_asset('js/plugins/icheck.min.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/jasny-bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ secure_asset('js/plugins/exporting.js') }}" type="text/javascript"></script>

<script type="text/javascript">
                    
    $(document).ready(function() {
        
        $('.footable').footable();
        
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        
        if (window.localStorage) {
            var inicio = localStorage.getItem("inicio");
            
            if (inicio!='si'){
                  alertaBienvenida();
                  localStorage.setItem("inicio", "si");
            }
            
            var alertaroja = localStorage.getItem("alertaroja");
            
            if (alertaroja!=null){
                alertaRoja(alertaroja);  
                localStorage.removeItem("alertaroja");
            }
            
            var alertaverde= localStorage.getItem("alertaverde");
            
            if (alertaverde!=null){
                alertaVerde(alertaverde);  
                localStorage.removeItem("alertaverde");
            }
        }else{
            alert('no local storage');
        }
        
        
        cambioNavBar();
        
    });
    
    
    $(window).resize(function() {
        $('body').resize();
        cambioNavBar();
    });
    
    function alertaBienvenida(){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success('{{ auth()->user()->nombre }}', 'Bienvenido');
    }
    
    function alertaRoja($mensaje){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.error($mensaje, 'Error');

    }
    
    
    function alertaVerde($msg){
        
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success($msg, '');
        
    }
    
    //Alerta al presionar boton eliminar en tablas
    $('.btnDelConfirm').click(function () {
        swal({
            title: "Estas seguro?",
            text: "El registro no podra ser recuperado!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (isConfirm) {
                swal("Eliminado!", "El registro fue eliminado.", "success");
               $('#delete').click();
            } else {
                return false;
            }
        });
        return false;
    });
    
   
    // En headerpanel se utiliza
    $('span[data-action="refresh"]').click(function(event) {
      
        location.reload();
       
        
    });
    
  
    function cambioNavBar(){
        // Enable/disable fixed side navbar
       
        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };
        
        
        if (isMobile.any() || $(window).width() < 630 ){
            
            $("body").addClass('fixed-sidebar');
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });

            if (localStorageSupport){
                localStorage.setItem("fixedsidebar",'on');
            }
        }else{
            $('.sidebar-collapse').slimscroll({destroy: true});
            $('.sidebar-collapse').attr('style', '');
            $("body").removeClass('fixed-sidebar');

            if (localStorageSupport){
                localStorage.setItem("fixedsidebar",'off');
            }
        }
         
       
        
    }
   
</script>  