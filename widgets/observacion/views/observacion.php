
<!--
<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalobs_" id="dalobs">Fechas</button>
-->
<!--Lista de Objetivos Especificos -->
<div class="modal fade" id="modalobs_" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Observación</h4>
            </div>
            <div class="modal-body">
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
                 <label>Describir el Motivo por el cual Observa el Proyecto.</label>   
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <div class="form-group field-proyecto-observacion required">
                        <textarea class="form-control" id="proyecto-observacion" name="Proyecto[observacion]" rows="10" requered></textarea>  
                    </div>
                </div>
                <div id="mensajeobs" ></div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>-->
                <button type="submit" id="btn_observacion" class="btn btn-primary" >Aceptar</button>
            </div>
        </div>
    </div>
</div>
