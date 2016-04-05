<a href="#" data-toggle="modal" data-target="#zona_accion" id="proyecto-zonaaccion">
    Locación Geográfica(UBIGEO)
</a>
<!--Lista de Objetivos Especificos -->
<div class="modal fade bs-example-modal-lg" id="zona_accion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Zona(s) de Acción</h4>
            </div>
            <div class="modal-body">
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <table class="table table-bordered table-hover" id="objetivos_especificos_tabla">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Departamento
                                </th>
                                <th class="text-center">
                                    Provincia
                                </th>
                                <th class="text-center">
                                    Distrito
                                </th>
                                <th class="text-center">
                                    Zona
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $za=0; ?>
			    <?php if($zonaaccion){ ?>
				
				<?php foreach($zonaaccion as $zonaaccion2){ ?>
				    <?php //if($objetivo->id==$proyecto->objetivo_especifico_1_id){ ?>
				    <tr id='objetivo_addr_1_<?= $za ?>'>
					<td>
					<?= ($za+1) ?>
					</td>
					<td>
					    <div class="form-group field-proyecto-objetivos_descripciones_<?= $za ?> required">
						
						<input type="text" id="proyecto-objetivos_descripciones_<?= $za ?>" class="form-control" name="Proyecto[objetivos_descripciones][]" placeholder="Descripción #<?= $za ?>" value="<?= $zonaaccion2->descripcion ?>" />
					    </div>
					</td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
						<input type="hidden" name="Proyecto[objetivos_ids][]" value="<?= $objetivoespecifico->id ?>" />
					    </span>
					</td>
				    </tr>
				    <?php $za++; ?>
				    <?php //}?>
				<?php } ?>
			    <?php }else{ ?>
				<tr id='zona_addr_1_0'>
				    <td>
				    <?= ($za+1) ?>
				    </td>
				    <td>
					<div class="form-group field-proyecto-zona_departamento_0 required">
                                            <select onchange="provincia(0);" id="proyecto-zona_departamento_0" name="Proyecto[zona_departamento][]" style="width:200px;">
                                                <option value="0">--Departamento--</option>
                                                <?php
                                                       foreach($departamentos as $departamentos2)
                                                        {
                                                ?>
                                                           <option value="<?= $departamentos2->department_id; ?>" > <?= $departamentos2->department ?></option>;
                                                <?php   } ?>
                            
                                             
                            
                                            </select>
					    
					</div>
				    </td>
                                    <td>
					<div class="form-group field-proyecto-zona_provincia_0 required">
					    <select  onchange="distrito(0);" id="proyecto-zona_provincia_0" name="Proyecto[zona_provincia][]" style="width:200px;">
                                                <option value="0">--Provincia--</option>                                            
                                            </select>
					</div>
				    </td>
                                    <td>
					<div class="form-group field-proyecto-zona_distrito_0 required">
					    <select  id="proyecto-zona_distrito_0" name="Proyecto[zona_distrito][]" style="width:200px;">
                                                <option value="0">--Distrito--</option>                                            
                                            </select>
					</div>
				    </td>
                                    <td>
					<div class="form-group field-proyecto-zona_zona_0 required">
					    <input type="text" id="proyecto-zona_zona_0" class="form-control" name="Proyecto[zona_zona][]" placeholder="Zona #1"  />
					</div>
				    </td>
				    <td>
					<span class="eliminar glyphicon glyphicon-minus-sign">
					</span>
				    </td>
				</tr>
				<?php $za=1; ?>
			    <?php } ?>
                            <tr id='objetivo_addr_1_<?= $za ?>'></tr>
                        </tbody>
                    </table>
                    <div id="objetivo_row_1" class="btn btn-default pull-left" value="1">Agregar</div>
                    <br>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btn_objetivos_especificos" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php
    $obtenerprovincia = Yii::$app->getUrlManager()->createUrl('proyecto/obtenerprovincia');
?>
<script>
    var za=<?= $za ?>;
    
    
    function provincia(identificador) {

        $.ajax({
                    url: '<?= $obtenerprovincia ?>',
                    type: 'GET',
                    async: true,
                    data: {id:$('#proyecto-zona_departamento_'+identificador).val()},
                    success: function(data){
                        $('#proyecto-zona_provincia_'+identificador).append(data);
                    }
                });
    }
    
    function distrito(valor) {
        //code
    }
    
 /*   $("#objetivos_especificos_tabla").on('click','.eliminar',function(){
        var r = confirm("Estas seguro?");
        if (r == true) {
            id=$(this).children().val();
            if (id) {
		$.ajax({
                    url: '<? $eliminaractividad ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id},
                    success: function(data){
                      
                    }
                });
		$(this).parent().parent().remove();	
	    }
	    else
	    {
		$(this).parent().parent().remove();
	    }
        } 
    });*/
    
    
    $("#objetivo_row_1").click(function(){
       console.log(oe);
        if($('#proyecto-objetivos_descripciones_'+(oe-1)).val()=='')
        {
            var error='ingrese el objetivo #'+oe+' <br>';
            $('.field-proyecto-objetivos_descripciones_'+(oe-1)).addClass('has-error');
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        
            $('.field-proyecto-objetivos_descripciones_'+(oe-1)).addClass('has-success');
            $('.field-proyecto-objetivos_descripciones_'+(oe-1)).removeClass('has-error');
            $('#objetivo_addr_1_'+oe).html("<td>"+ (oe+1) +"</td><td><div class='form-group field-proyecto-objetivos_descripciones_"+oe+" required'><input id='proyecto-objetivos_descripciones_"+oe+"' name='Proyecto[objetivos_descripciones][]' type='text' placeholder='Descripción #"+(oe+1)+"' class='form-control'  /></div></td><td><span class='eliminar glyphicon glyphicon-minus-sign'></span></td>");
            $('#objetivos_especificos_tabla').append('<tr id="objetivo_addr_1_'+(oe+1)+'"></tr>');
            oe++;
        
        
        
        return true;
    });
    
    $("#btn_objetivos_especificos").click(function(event){
	var error='';
        var objetivo1=$('input[name=\'Proyecto[objetivos_descripciones][]\']').length;
        for (var i=0; i<objetivo1; i++) {
            if($('#proyecto-objetivos_descripciones_'+i).val()=='')
            {
                error=error+'ingrese el objetivo especifico #'+i+'  <br>';
                $('.field-proyecto-objetivos_descripciones_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-objetivos_descripciones_'+i).addClass('has-success');
                $('.field-proyecto-objetivos_descripciones_'+i).removeClass('has-error');
            }
        }
	
	if (error!='') {
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        else
        {
	    $( "#w0" ).submit();
            return true;
        }
    });
    
    $("#proyecto-zonaaccion").click(function( ) {
	var id='<?= $proy_zonaaccion_id ?>';
	console.log(id);
	if (id=='') {
	    $.notify({
                message: 'No existe proyecto registrado'
            },{
                type: 'danger',
                offset: 20,
                spacing: 10,
                z_index: 1031,
                placement: {
                    from: 'top',
                    align: 'right'
                },
            });
            return false;
	}
	return true;
    });
    
</script>