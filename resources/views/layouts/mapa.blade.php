



<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ubicación Oficina</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" id="divSearch">
                    <div class="col-sm-12">
                        <div class="input-group m-b">
                            <span class="input-group-prepend">
                                <button type="button" class="btn btn-primary" id="btn_search"> <i class="fa fa-search"></i> </button>
                            </span> 
                            <input class="form-control" type="text" name="address" id="address-field" value="">
                        </div>
                    </div>
                </div>
                 
                    
                <div id="map">
                    
                </div>
                    
                <input type="hidden" name="marker_latitud" id="marker_latitud">
                <input type="hidden" name="marker_longitud" id="marker_longitud">
                <input type="hidden" name="marker_address" id="marker_address">                         
                                    
                
            </div>
    
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Guardar Cambios</button>
                <input type="hidden" id="r_id" name="r_id" value="0">
            </div>
        </div>
    </div>
</div>


