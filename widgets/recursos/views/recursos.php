<div class="clearfix"></div>

<div class="col-xs-12 col-sm-7 col-md-12">
    <h5>Recursos</h5>
                    <table class="table table-bordered table-hover" id="recurso_tabla">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Clasificador
                                </th>
                                <th class="text-center">
                                    Detalle
                                </th>
                                <th class="text-center">
                                    Unidad
                                </th>
                                <th class="text-center">
                                    Cantidad
                                </th>
                                <th class="text-center">
                                    P. Unit.
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $re=0; ?>
			    <?php if($recursos){ ?>
				
				<?php foreach($recursos as $recursos2){ ?>
				    <?php //if($objetivo->id==$proyecto->objetivo_especifico_1_id){ ?>
				    <tr id='recurso_addr_1_<?= $re ?>'>
					<td>
					<?= ($re+1) ?>
                                        <input type="hidden" name="Proyecto[recurso_numero][]" id="proyecto-recurso_numero_<?= $re; ?>" value="<?= $re; ?>" />
					</td>
					<td>
                                        <div class="form-group field-proyecto-recurso_clasificador_<?= $re; ?> required">
                                            <select  class="form-control " id="proyecto-recurso_clasificador_<?= $re; ?>" name="Proyecto[recurso_clasificador][]" >
                                                <option value="0">--Clasificador--</option>
                                                <?php
                                                       foreach($clasificador as $clasificador2)
                                                        {
                                                ?>
                                                           <option value="<?= $clasificador2->id; ?>" <?=($clasificador2->id == $recursos2->clasificador_id)?'selected':'' ?>> <?= $clasificador2->descripcion ?></option>;
                                                <?php   } ?>
                            
                                             
                            
                                            </select>
					    
                                            </div>    
                                        </td>
                                        <td class="col-xs-3"  >
                                            <div class="form-group field-proyecto-recurso_descripcion_<?= $re; ?> required">
                                                <input class="form-control " value="<?= $recursos2->detalle ?>" type="text"  placeholder="..." id="proyecto-recurso_descripcion_<?= $re; ?>" name="Proyecto[recurso_descripcion][]"/>
                                            </div>
                                        </td>
                                        <td class="col-xs-3">
                                            <div class="form-group field-proyecto-recurso_unidad_<?= $re; ?> required">
                                                <input class="form-control " value="<?= $recursos2->unidad_medida ?>" type="text"  placeholder="..." id="proyecto-recurso_unidad_<?= $re; ?>" name="Proyecto[recurso_unidad][]"/>
                                            </div>
                                        </td>
                                        <td class="col-xs-1">
                                            <div class="form-group field-proyecto-recurso_cantidad_<?= $re; ?> required">
                                                <input  class="form-control " value="<?= $recursos2->cantidad ?>" class="form-control " type="text"  placeholder="..." id="proyecto-recurso_cantidad_<?= $re; ?>" name="Proyecto[recurso_cantidad][]"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group field-proyecto-recurso_precioun_<?= $re; ?> required">
                                                <input class="form-control " value="<?= $recursos2->precio_unit ?>" class="form-control "  type="text"  placeholder="..." id="proyecto-recurso_precioun_<?= $re; ?>" name="Proyecto[recurso_precioun][]"/>
                                            </div>
                                        </td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
						<input type="hidden" name="Proyecto[recurso_ids][]" value="<?= $recursos2->id ?>" />
					    </span>
					</td>
				    </tr>
				    <?php $re++; ?>
				    <?php //}?>
				<?php } ?>
			    <?php }else{ ?>
				<tr id='recurso_addr_1_0'>
				    <td>
				    <?= ($re+1) ?>
                                    <input type="hidden" name="Proyecto[recurso_numero][]" id="proyecto-recurso_numero_<?= $re; ?>" value="<?= $re; ?>" />
				    </td>
				    <td class="col-xs-2" >
					<div class="form-group field-proyecto-recurso_clasificador_0 required">
                                            <select  class="form-control " id="proyecto-recurso_clasificador_0" name="Proyecto[recurso_clasificador][]" >
                                                <option value="0">--Clasificador--</option>
                                                <?php
                                                       foreach($clasificador as $clasificador2)
                                                        {
                                                ?>
                                                           <option value="<?= $clasificador2->id; ?>" > <?= $clasificador2->descripcion ?></option>;
                                                <?php   } ?>
                            
                                             
                            
                                            </select>
					    
					</div>
				    </td>
                                    <td class="col-xs-3"  >
					<div class="form-group field-proyecto-recurso_descripcion_0 required">
					    <input class="form-control " type="text"  placeholder="..." id="proyecto-recurso_descripcion_0" name="Proyecto[recurso_descripcion][]"/>
					</div>
				    </td>
                                    <td class="col-xs-3">
					<div class="form-group field-proyecto-recurso_unidad_0 required">
					    <input class="form-control " type="text"  placeholder="..." id="proyecto-recurso_unidad_0" name="Proyecto[recurso_unidad][]"/>
					</div>
				    </td>
                                    <td class="col-xs-1">
					<div class="form-group field-proyecto-recurso_cantidad_0 required">
					    <input  class="form-control " class="form-control " type="text"  placeholder="..." id="proyecto-recurso_cantidad_0" name="Proyecto[recurso_cantidad][]"/>
					</div>
				    </td>
                                    <td>
					<div class="form-group field-proyecto-recurso_precioun_0 required">
					    <input class="form-control " class="form-control "  type="text"  placeholder="..." id="proyecto-recurso_precioun_0" name="Proyecto[recurso_precioun][]"/>
					</div>
				    </td>
				    <td>
					<span class="eliminar glyphicon glyphicon-minus-sign">
					    
					</span>
				    </td>
				</tr>
				<?php $re=1; ?>
			    <?php } ?>
                            <tr id='recurso_addr_1_<?= $re ?>'></tr>
                        </tbody>
                    </table>
                    <div id="recurso_row_1" class="btn btn-default pull-left" value="1">Agregar</div>
                    <br>
                </div>
        <div id="control_boton">
                <button type="submit" id="btn_recursos" class="btn btn-primary" >Guardar</button>
        </div>
<?php
    $eliminarrecurso = Yii::$app->getUrlManager()->createUrl('proyecto/eliminarrecurso');
    $refrescarrecurso = Yii::$app->getUrlManager()->createUrl('proyecto/refrescarrecursos');
?>
<script>
 
 var re = <?= $re; ?>
 
 $( "#proyecto-id_actividad" ).change(function() {
    
  var id_actividad = $(this).val();
  $('#recurso_tabla > tbody > tr').remove();
        
        $.ajax({
                    url: '<?= $refrescarrecurso ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id_actividad},
                    success: function(data){
			var valor = jQuery.parseJSON(data);
                        $('#recurso_tabla').append(valor.html);
                       re = valor.contador;
                       console.log(re);
                    }
                });
  
  
  
});
 
 $("#recurso_row_1").click(function(){
	
	var error = '';
        var clasificador=($('input[name=\'Proyecto[recurso_descripcion][]\']').length);
        var valor=($('input[name=\'Proyecto[recurso_numero][]\']').serializeArray());
        
        for (var i=0; i<clasificador; i++) {
            if(($('#proyecto-recurso_clasificador_'+(valor[i].value)).val()=='0') || ($.trim($('#proyecto-recurso_descripcion_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-recurso_unidad_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-recurso_cantidad_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-recurso_precioun_'+(valor[i].value)).val())==''))
            {
                error=error+'Complete todos los Campos del Recurso #'+((parseInt(valor[i].value)) + 1)+' <br>';
               // $('.field-proyecto-descripciones_'+i).addClass('has-error');
            }
            else
            {
               // $('.field-proyecto-descripciones_'+i).addClass('has-success');
               // $('.field-proyecto-descripciones_'+i).removeClass('has-error');
            }
        }
       
	/*var clasificador = $('#proyecto-recurso_clasificador_'+(re-1));
	var descripcion = $('#proyecto-recurso_descripcion_'+(re-1));
	var unidad = $('#proyecto-recurso_unidad_'+(re-1));
	var cantidad = $('#proyecto-recurso_cantidad_'+(re-1));
        var precioun = $('#proyecto-recurso_precioun_'+(re-1));
	
       
        if(clasificador.val()=='0')
        {
            error += "Ingrese Clasificador Nro "+re+" <br>";
	    $('.field-proyecto-recurso_clasificador_'+(re-1)).addClass('has-success');
            $('.field-proyecto-recurso_clasificador_'+(re-1)).removeClass('has-error');
	}
	
	if($.trim(descripcion.val())=='')
        {
            error += "Ingrese Detalle Nro "+re+" <br>";
	    $('.field-proyecto-recurso_descripcion_'+(re-1)).addClass('has-success');
            $('.field-proyecto-recurso_descripcion_'+(re-1)).removeClass('has-error');
	}
	
	if($.trim(unidad.val())=='')
        {
            error += "Ingrese la Unidad de Medida Nro "+re+" <br>";
	    $('.field-proyecto-recurso_unidad_'+(re-1)).addClass('has-success');
            $('.field-proyecto-recurso_unidad_'+(re-1)).removeClass('has-error');
	}
        
        if($.trim(cantidad.val())=='')
        {
            error += "Ingrese la Cantidad Nro "+re+" <br>";
	    $('.field-proyecto-recurso_cantidad_'+(re-1)).addClass('has-success');
            $('.field-proyecto-recurso_cantidad_'+(re-1)).removeClass('has-error');
	}
        
        if($.trim(precioun.val())=='')
        {
            error += "Ingrese el Precio Unitario Nro "+re+" <br>";
	    $('.field-proyecto-recurso_precioun_'+(re-1)).addClass('has-success');
            $('.field-proyecto-recurso_precioun_'+(re-1)).removeClass('has-error');
	}*/
	
	if (error != '') {
	    
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
            $('#recurso_addr_1_'+re).html('<td>'+(re+1)+'<input type="hidden" name="Proyecto[recurso_numero][]" id="proyecto-recurso_numero_'+re+'" value="'+re+'" /></td><td class="col-xs-2" ><div class="form-group field-proyecto-recurso_clasificador_'+re+' required"><select  class="form-control " id="proyecto-recurso_clasificador_'+re+'" name="Proyecto[recurso_clasificador][]" ><option value="0">--Clasificador--</option><?php foreach($clasificador as $clasificador2) { ?> <option value="<?= $clasificador2->id; ?>" > <?= $clasificador2->descripcion ?></option>; <?php   } ?></select></div></td><td class="col-xs-3"  ><div class="form-group field-proyecto-recurso_descripcion_'+re+' required"><input class="form-control " type="text"  placeholder="..." id="proyecto-recurso_descripcion_'+re+'" name="Proyecto[recurso_descripcion][]"/></div></td><td class="col-xs-3"><div class="form-group field-proyecto-recurso_unidad_'+re+' required"><input class="form-control " type="text"  placeholder="..." id="proyecto-recurso_unidad_'+re+'" name="Proyecto[recurso_unidad][]"/></div></td><td class="col-xs-1"><div class="form-group field-proyecto-recurso_cantidad_'+re+' required"><input  class="form-control " class="form-control " type="text"  placeholder="..." id="proyecto-recurso_cantidad_'+re+'" name="Proyecto[recurso_cantidad][]"/></div></td><td><div class="form-group field-proyecto-recurso_precioun_'+re+' required"><input class="form-control " class="form-control "  type="text"  placeholder="..." id="proyecto-recurso_precioun_'+re+'" name="Proyecto[recurso_precioun][]"/></div></td><td><span class="eliminar glyphicon glyphicon-minus-sign"></span></td>');
            $('#recurso_tabla').append('<tr id="recurso_addr_1_'+(re+1)+'"></tr>');
            re++;
        return true;
    
        }
        
        
    });
 
 
 $("#recurso_tabla").on('click','.eliminar',function(){
        var r = confirm("Estas seguro de Eliminar?");
        var mensaje = '';
        if (r == true) {
            id=$(this).children().val();
            if (id) {
		$.ajax({
                    url: '<?= $eliminarrecurso ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id},
                    success: function(data){
			
                        mensaje = data;
                    }
                });
		$(this).parent().parent().remove();	
	    }
	    else
	    {
		$(this).parent().parent().remove();
                
                mensaje = "Se elimino el Recurso Correctamente";
	    }
            
            $.notify({
					    message: mensaje 
					},{
					    type: 'danger',
					    z_index: 1000000,
					    placement: {
						from: 'top',
						align: 'right'
					    },
					});
            
            
        } 
    });
    
    $("#btn_recursos").click(function(event){
        
        	
	var error='';
        var clasificador=($('input[name=\'Proyecto[recurso_descripcion][]\']').length);
        var valor=($('input[name=\'Proyecto[recurso_numero][]\']').serializeArray());
        
        //console.log(valor);
        //console.log('-'+clasificador);
        //alert(clasificador);
        
        for (var i=0; i<clasificador; i++) {
            
            
           // console.log(valor[i].value);
            if(($('#proyecto-recurso_clasificador_'+(valor[i].value)).val()=='0') || ($.trim($('#proyecto-recurso_descripcion_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-recurso_unidad_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-recurso_cantidad_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-recurso_precioun_'+(valor[i].value)).val())==''))
            {
                error=error+'Complete todos los Campos del Recurso #'+((parseInt(valor[i].value)) + 1)+' <br>';
               // $('.field-proyecto-descripciones_'+i).addClass('has-error');
            }
            else
            {
               // $('.field-proyecto-descripciones_'+i).addClass('has-success');
               // $('.field-proyecto-descripciones_'+i).removeClass('has-error');
            }
        }
	
	if (error!='') {
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'top',
                    align: 'right'
                },
            });
            return false;
        }
        else
        {
           
            return true;
        }
    });
    
    
    
</script>