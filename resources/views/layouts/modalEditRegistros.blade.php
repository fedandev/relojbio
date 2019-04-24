<!-- Passing BASE URL to AJAX -->

<input id="url" type="hidden" value="{{ URL::to('/') }}">


<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Registro</h4>
            </div>
            <div class="modal-body">
                <form id="frmRegistros" name="frmRegistros" class="form-horizontal" novalidate="">
                 
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Hora</label>
                        <div class="col-sm-5">
                            <input  disabled class="form-control" type="text" name="r_hora" id="r_hora">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Fecha</label>
                        <div class="col-sm-5">
                            <input disabled class="form-control" type="date" name="r_fecha" id="r_fecha" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Marca</label>
                        <div class="col-sm-5">
                            <select class="form-control m-b" name="r_tipo" id="r_tipo" >
                                <option value="I"> Entrada</option>
                                <option value="O"> Salida</option>
                            </select>
                        </div>
                    </div>
                    
                    <input type="hidden" name="r_tipomarca">
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Dispositivo</label>
                        <div class="col-sm-5">
                            <select disabled class="form-control" name="r_dispositivo" id="r_dispositivo">
                                @include('layouts.dispositivos')
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Empleado</label>
                        <div class="col-sm-6">
                            <select disabled class="form-control" name="r_cedula" id="r_cedula">
                                @include('layouts.empleadosXcedula');
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Comentarios</label>
                        <div class="col-sm-8"><textarea class="form-control" rows="4" cols="50" name="r_comentarios" id="r_comentarios"></textarea></div>
                    </div>
                                      
                                    
                </form>
            </div>
    
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Guardar Cambios</button>
                <input type="hidden" id="r_id" name="r_id" value="0">
            </div>
        </div>
    </div>
</div>


