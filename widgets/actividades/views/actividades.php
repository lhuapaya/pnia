<?php
/*$indicadores_opciones='';
foreach($indicadores as $indicador)
{
    $indicadores_opciones=$indicadores_opciones.'<option value="'.$indicador->id.'">'.$indicador->descripcion.'</option>';
}
*/
?>

<div>
   
            <div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
		    <h5>Actividades</h5>
                    <table class="table table-bordered table-hover" id="actividades_tabla">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Descripción
                                </th>
				<th class="text-center">
                                    Id. BID
                                </th>
				<th class="text-center">
                                    Peso
                                </th>
				<th class="text-center">
                                    Unidad de Medida
                                </th>
				<th class="text-center">
                                    Cant. Programada
                                </th>
				<th>
                                    
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $act=0; ?>
			    <?php if($actividades){ ?>
				
				<?php foreach($actividades as $actividad){?>
				    <tr id='actividad_addr_1_<?= $act ?>'>
					<td>
					<?= ($act+1) ?>
					<input type="hidden" name="Proyecto[actividades_numero][]" id="proyecto-actividades_numero_<?= $act; ?>" value="<?= $act; ?>" />
					</td>
					<td class="col-xs-4">
					    <div class="form-group field-proyecto-actividades_descripciones_<?= $act ?> required">
						<input type="text" id="proyecto-actividades_descripciones_<?= $act ?>" class="form-control" name="Proyecto[actividades_descripciones][]" placeholder="Descripción #<?= $act ?>" value="<?= $actividad->descripcion ?>" />
					    </div>
					</td>
					<td class="col-xs-1">
                                        <div class="form-group field-proyecto-actividades_indicadorbid_<?= $act; ?> required">
                                            <select  class="form-control " id="proyecto-actividades_indicadorbid_<?= $act; ?>" name="Proyecto[actividades_indicadorbid][]" >
                                                <option value="0">--Indicador BID--</option>
                                                <?php
                                                       foreach($indicadorBID as $indicadorBID2)
                                                        {
                                                ?>
                                                           <option value="<?= $indicadorBID2->id; ?>" <?=($indicadorBID2->id == $actividad->id_bid)?'selected':'' ?>> <?= $indicadorBID2->descripcion ?></option>;
                                                <?php   } ?>
                            
                                             
                            
                                            </select>
					    
                                            </div>    
                                        </td>
					<td class="col-xs-1">
					    <div class="form-group field-proyecto-actividades_pesos_<?= $act ?> required">
						<input type="text" id="proyecto-actividades_pesos_<?= $act ?>" class="form-control" name="Proyecto[actividades_pesos][]" placeholder="Peso" value="<?= $actividad->peso ?>" />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-actividades_unidad_medidas_<?= $act ?> required">
						<input type="text" id="proyecto-actividades_unidad_medidas_<?= $act ?>" class="form-control" name="Proyecto[actividades_unidad_medidas][]" placeholder="Unidad de Medida" value="<?= $actividad->unidad_medida ?>" />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-actividades_programados_<?= $act ?> required">
						<input type="text" id="proyecto-actividades_programados_<?= $act ?>" class="form-control" name="Proyecto[actividades_programados][]" placeholder="Cantidad Programada<?= $act ?>" value="<?= $actividad->programado ?>" />
					    </div>
					</td>
					<td>
					    <div>
					    <?= \app\widgets\fechas\FechasWidget::widget(['actividad_id'=>$actividad->id,'act'=>$act]); ?> 
					    </div>
					</td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
						<input type="hidden" name="Proyecto[actividades_ids][]" value="<?= $actividad->id ?>" />
					    </span>
					</td>
				    </tr>
				    <?php $act++; ?>
				<?php } ?>
			    <?php }else{ ?>
				<tr id='actividad_addr_1_0'>
				    <td>
					<?= ($act+1) ?>
					<input type="hidden" name="Proyecto[actividades_numero][]" id="proyecto-actividades_numero_<?= $act; ?>" value="<?= $act; ?>" />
					</td>
					<td class="col-xs-4">
					    <div class="form-group field-proyecto-actividades_descripciones_0 required">
						<input type="text" id="proyecto-actividades_descripciones_0" class="form-control" name="Proyecto[actividades_descripciones][]" placeholder="Descripción #<?= $act ?>"  />
					    </div>
					</td>
					<td class="col-xs-1">
                                        <div class="form-group field-proyecto-actividades_indicadorbid_0 required">
                                            <select  class="form-control " id="proyecto-actividades_indicadorbid_0" name="Proyecto[actividades_indicadorbid][]" >
                                                <option value="0">--Indicador BID--</option>
                                                <?php
                                                       foreach($indicadorBID as $indicadorBID2)
                                                        {
                                                ?>
                                                           <option value="<?= $indicadorBID2->id; ?>" > <?= $indicadorBID2->descripcion ?></option>;
                                                <?php   } ?>
                            
                                             
                            
                                            </select>
					    
                                            </div>    
                                        </td>
					<td class="col-xs-1">
					    <div class="form-group field-proyecto-actividades_pesos_0 required">
						<input type="text" id="proyecto-actividades_pesos_0" class="form-control" name="Proyecto[actividades_pesos][]" placeholder="" " />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-actividades_unidad_medidas_0 required">
						<input type="text" id="proyecto-actividades_unidad_medidas_0" class="form-control" name="Proyecto[actividades_unidad_medidas][]" placeholder=""  />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-actividades_programados_0 required">
						<input type="text" id="proyecto-actividades_programados_0" class="form-control" name="Proyecto[actividades_programados][]" placeholder="" />
					    </div>
					</td>
					<td>
					    <div>
					    <?= \app\widgets\fechas\FechasWidget::widget(['actividad_id'=>$actividad->id,'act'=>$act]); ?> 
					    </div>
					</td>
				    <td>
					<span class="eliminar glyphicon glyphicon-minus-sign">
					</span>
				    </td>
				</tr>
				<?php $act=1; ?>
			    <?php } ?>
                            <tr id='actividad_addr_1_<?= $act ?>'></tr>
                        </tbody>
                    </table>
                    <div id="actividades_row_1" class="btn btn-default pull-left" value="1">Agregar</div>
                    <br>
                </div>
                <div class="clearfix"></div>
		<div id="control_boton">
                <button type="submit" id="btn_actividades" class="btn btn-primary" >Guardar</button>
        </div>
            </div>

</div>

<?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminaractividad');
    $refrescaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/refrescaractividades');
?>
<script>
   var act = <?= $act; ?>

 $( "#proyecto-id_indicador" ).change(function() {
    
  var id_indicador = $(this).val();
  $('#actividades_tabla > tbody > tr').remove();
        
        $.ajax({
                    url: '<?= $refrescaractividad ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id_indicador},
                    success: function(data){
			var valor = jQuery.parseJSON(data);
                        $('#actividades_tabla').append(valor.html);
                       act = valor.contador;
                       console.log(act);
                    }
                });
  
  
  
});


   
 $("#actividades_tabla").on('click','.eliminar',function(){
        var r = confirm("Estas seguro de Eliminar?");
	var mensaje = '';
	var estado2 = 0;
	var valor = null;
	//var valor = null;
        if (r == true) {
            id=$(this).children().val();
	    
            if (id) {
		$.ajax({
                    url: '<?= $eliminaractividad ?>',
                    type: 'GET',
                    async: false,
                    data: {id:id},
                    success: function(data){
			var valor = jQuery.parseJSON(data);
			
			valor = jQuery.parseJSON(data);
			estado2 = valor.estado ;
			mensaje = valor.mensaje;

			
				
                    }
                });
		
		if (estado2 == 1)
		    {
		    $(this).parent().parent().remove();
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
	    else
	    {
		$(this).parent().parent().remove();
		$.notify({
					    message: "Se elimino la Actividad Correctamente"
					},{
					    type: 'danger',
					    z_index: 1000000,
					    placement: {
						from: 'top',
						align: 'right'
					    },
					});

	    }
	    
	    
        }

    }); 
    
    
    
    $("#actividades_row_1").click(function(){

        var error = '';
        var cantidadregistros=($('input[name=\'Proyecto[actividades_descripciones][]\']').length);
        var valor=($('input[name=\'Proyecto[actividades_numero][]\']').serializeArray());
        
        for (var i=0; i<cantidadregistros; i++) {
            if(($.trim($('#proyecto-actividades_descripciones_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_indicadorbid_'+(valor[i].value)).val())=='0') || ($.trim($('#proyecto-actividades_pesos_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_unidad_medidas_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_programados_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_finicio_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_ffin_'+(valor[i].value)).val())==''))
            {
                error=error+'Complete todos los Campos de la Actividad #'+((parseInt(valor[i].value)) + 1)+' <br>';
               // $('.field-proyecto-descripciones_'+i).addClass('has-error');
            }

        }
	
        if(error!='')
        {
            //var error='ingrese el objetivo #'+i+' <br>';
            //$('.field-proyecto-actividades_descripciones_'+(i-1)).addClass('has-error');
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

            $('#actividad_addr_1_'+act).html('<td>'+(act+1)+'<input type="hidden" name="Proyecto[actividades_numero][]" id="proyecto-actividades_numero_'+act+'" value="'+act+'" /></td><td class="col-xs-4"><div class="form-group field-proyecto-actividades_descripciones_'+act+' required"><input type="text" id="proyecto-actividades_descripciones_'+act+'" class="form-control" name="Proyecto[actividades_descripciones][]" placeholder="" /></div></td><td class="col-xs-1"><div class="form-group field-proyecto-actividades_indicadorbid_'+act+' required"><select  class="form-control " id="proyecto-actividades_indicadorbid_'+act+'" name="Proyecto[actividades_indicadorbid][]" ><option value="0">--Indicador BID--</option><?php foreach($indicadorBID as $indicadorBID2){ ?> <option value="<?= $indicadorBID2->id; ?>" > <?= $indicadorBID2->descripcion ?></option>; <?php   } ?> </select></div></td><td class="col-xs-1"><div class="form-group field-proyecto-actividades_pesos_'+act+' required"><input type="text" id="proyecto-actividades_pesos_'+act+'" class="form-control" name="Proyecto[actividades_pesos][]" placeholder=""  /></div></td><td><div class="form-group field-proyecto-actividades_unidad_medidas_'+act+' required"><input type="text" id="proyecto-actividades_unidad_medidas_'+act+'" class="form-control" name="Proyecto[actividades_unidad_medidas][]" placeholder=""  /></div></td><td><div class="form-group field-proyecto-actividades_programados_'+act+' required"><input type="text" id="proyecto-actividades_programados_'+act+'" class="form-control" name="Proyecto[actividades_programados][]" placeholder=""  /></div></td><td><div id="ruta_'+act+'"></div></td><td><span class="eliminar glyphicon glyphicon-minus-sign"></span></td>');
	    
	    
	    $('#ruta_'+act).html('<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#fechas'+act+'_" id="fechas">Fechas</button>'+
'<div class="modal fade" id="fechas'+act+'_" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
    '<div class="modal-dialog" role="document">'+
        '<div class="modal-content">'+
            '<div class="modal-header">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<h4 class="modal-title" id="myModalLabel">Fechas</h4>'+
            '</div><div class="modal-body"><div class="clearfix"></div>'+
                '<div class="col-xs-12 col-sm-7 col-md-12"><table class="table table-bordered table-hover" id="fechas_tabla">'+
                        '<thead><tr><th class="text-center">#</th><th class="text-center">Fecha Inicio</th>'+
				'<th class="text-center">Fecha Fin</th><th></th></tr></thead><tbody><tr>'+
					'<td>'+(act+1)+'</td><td class="col-xs-1"><div class="form-group field-proyecto-actividades_finicio_'+act+' required">'+
					'<input type="month" id="proyecto-actividades_finicio_'+act+'" class="form-control" name="Proyecto[actividades_finicio][]" placeholder="Mes" />'+
					 '</div></td><td class="col-xs-1"><div class="form-group field-proyecto-actividades_ffin_'+act+' required">'+
					'<input type="month" id="proyecto-actividades_ffin_'+act+'" class="form-control" name="Proyecto[actividades_ffin][]" placeholder="Mes" />'+
					 '</div></td><td></td></tr></tbody></table><br></div><div class="clearfix"></div></div>'+
            '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>'+
                     '</div></div></div></div>');
	    
	    
	    
	    $('#actividades_tabla').append('<tr id="actividad_addr_1_'+(act+1)+'"></tr>');
            act++;
        }
        
        
        return true;
    });
    
  $("#btn_actividades").click(function(event){
	var error = '';
        var cantidadregistros=($('input[name=\'Proyecto[actividades_descripciones][]\']').length);
        var valor=($('input[name=\'Proyecto[actividades_numero][]\']').serializeArray());
        
        for (var i=0; i<cantidadregistros; i++) {
            if(($.trim($('#proyecto-actividades_descripciones_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_indicadorbid_'+(valor[i].value)).val())=='0') || ($.trim($('#proyecto-actividades_pesos_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_unidad_medidas_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_programados_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_finicio_'+(valor[i].value)).val())=='') || ($.trim($('#proyecto-actividades_ffin_'+(valor[i].value)).val())==''))
            {
                error=error+'Complete todos los Campos de la Actividad #'+((parseInt(valor[i].value)) + 1)+' <br>';
               // $('.field-proyecto-descripciones_'+i).addClass('has-error');
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
            return true;
        }
    });  
    
    
</script>