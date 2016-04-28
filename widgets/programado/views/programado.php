

<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#programado<?= $re ?>_" id="btn_programado" onclick="cargartitulos(<?= $re ?>)">Detalle</button>
<!--Lista de Objetivos Especificos -->
<div class="modal fade bs-example-modal-lg" id="programado<?= $re ?>_" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detalle <?= ($re+1) ?></h4>
            </div>
            <div class="modal-body">
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-8">
                   <label>Objetivo: <span id="obj_programado_<?= $re ?>"></span></label> 
                </div>
                <div class="col-xs-12 col-sm-7 col-md-8">
                    <label>Indicador: <span id="ind_programado_<?= $re ?>"></span></label> 
                </div>
                <div class="col-xs-12 col-sm-7 col-md-8">
                    <label>Actividad: <span id="act_programado_<?= $re ?>"></span></label> 
                </div>
                <div class="clearfix"></div><br/>
                <div class="col-xs-12 col-sm-7 col-md-3">
                    <label>Año</label>
                    <select id="proyecto-anio_<?= $re ?>" class="form-control" name="Proyecto[anio]">
                        <option value="1" selected>Primer Año</option>
                        <option value="1">Segundo Año</option>
                        <option value="1">Primer Año</option>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-3">
                    <label>Precio Unitario</label>
                    <input type="text" id="proyecto-precio_unit_<?= $re ?>" class="form-control" name="Proyecto[precio_unit]" placeholder="" value="<?= $recursos->precio_unit ?>" />
                </div>
                <div class="clearfix"></div><br/
                <div class="col-xs-12 col-sm-7 col-md-12">
                 <input type="hidden" id="proyecto-id_recurso_<?= $re ?>" class="form-control" name="Proyecto[id_recurso_prog]" placeholder="" value="<?= $rec_prog_id ?>" />   
                    <table class="table table-bordered table-hover" id="programado_tabla_<?= $re ?>">
                        <!--<thead>
                            <tr>
                                <th class="text-center">
                                    
                                </th>
                                <th class="text-center">
                                    
                                </th>
				<th class="text-center">
                                    
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>-->
                        <tbody>
                            <tr>
			    <?php if($programado){
                                $mes = [];
                                $cantidad = [];
                                $id = [];
                                
                                foreach($programado as $programado2)
                                {
                                    $mes[] = $programado2->mes;
                                    $cantidad[] = $programado2->cantidad;
                                    $id[] = $programado2->id;
                                }
                                for($i=1; $i<=12; $i++)
                                {
                            ?>        
                                  <td>
					    <div class="form-group field-proyecto-programado_mes_<?= $re ?>_<?= $i; ?> required">
						<input type="text" id="proyecto-programado_cantidad_<?= $re ?>_<?= $i; ?> " class="form-control entero" name="Proyecto[programado_cantidad][]" placeholder="" <?=($mes[$i] == $i)?'value="'.$cantidad[$i].'"':'' ?>  />
                                                <input type="hidden" id="proyecto-programado_mes_<?= $re ?>_<?= $i; ?> " class="form-control" name="Proyecto[programado_mes][]" placeholder="" value="<?= $i ?>" />
                                                <input type="hidden" id="proyecto-programado_id_<?= $re ?>_<?= $i; ?> " class="form-control" name="Proyecto[programado_id][]" placeholder="" value="<?= $id[$i] ?>" />
					    </div>
                                    </td>  
                            <?php
                                }
                            }else{
                                
                                for($i=1; $i<=12; $i++)
                                {
                            ?>        
                                  <td>
					    <div class="form-group field-proyecto-programado_mes_<?= $re ?>_<?= $i; ?> required">
						<input type="text" id="proyecto-programado_cantidad_<?= $re ?>_<?= $i; ?>" class="form-control entero" name="Proyecto[programado_cantidad][]" placeholder="" value="0" />
                                                <input type="hidden" id="proyecto-programado_mes_<?= $re ?>_<?= $i; ?>" class="form-control" name="Proyecto[programado_mes][]" placeholder="" value="<?= $i; ?>" />
					    </div>
                                    </td>  
                            <?php
                                }}
                            ?>
				
				</tr>
                        </tbody>
                    </table>
                    <br>
                </div>
                <div class="clearfix"></div>
                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button  onclick="grabar(<?= $re ?>)" type="button" id="btn_colaboradores" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>

    
function cargartitulos(re) {
                                   
   $("#obj_programado_"+re).html($("#proyecto-id_objetivo option:selected").html());
   $("#ind_programado_"+re).html($("#proyecto-id_indicador option:selected").html());
   $("#act_programado_"+re).html($("#proyecto-id_actividad option:selected").html()); 
}

function grabar(valor) {
    
    
    
}


</script>