<a href="#" data-toggle="modal" data-target="#colaboradores" id="proyecto-colaboradores" >
        Lista de Colaboradores
</a>
<!--Lista de Objetivos Especificos -->
<div class="modal fade bs-example-modal-lg" id="colaboradores" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Colaboradores</h4>
            </div>
            <div class="modal-body">
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
                    <table class="table table-bordered table-hover" id="colaboradores_tabla">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Nombres
                                </th>
                                <th class="text-center">
                                    Apellidos
                                </th>
                                <th class="text-center">
                                    Función Técnica
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>
			    <?php if($colaborador){ ?>
				
				<?php foreach($colaborador as $colaborador2){?>
				    <?php //if($objetivo->id==$proyecto->objetivo_especifico_1_id){ ?>
				    <tr id='addr_1_<?= $i ?>'>
					<td>
					<?= ($i+1) ?>
					</td>
					<td>
					    <div class="form-group field-proyecto-descripciones_<?= $i ?> required">
						
						<input type="text" id="proyecto-descripciones_<?= $i ?>" class="form-control" name="Proyecto[descripciones][]" placeholder="Descripción #<?= $i ?>" value="<?= $colaborador2->nombres ?>" />
					    </div>
					</td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
						<input type="hidden" name="Proyecto[ids][]" value="<?= $colaborador2->id ?>" />
					    </span>
					</td>
				    </tr>
				    <?php $i++; ?>
				    <?php //}?>
				<?php } ?>
			    <?php }else{ ?>
				<tr id='addr_1_0'>
				    <td>
				    <?= ($i+1) ?>
				    </td>
				    <td>
					<div class="form-group field-proyecto-nombresc_0 required">
					    <input type="text" id="proyecto-nombresc_0" class="form-control" name="Proyecto[nombresc][]" placeholder="Descripción #0"  />
					</div>
				    </td>
                                    <td>
					<div class="form-group field-proyecto-aapellidosc_0 required">
					    <input type="text" id="proyecto-aapellidosc_0" class="form-control" name="Proyecto[apellidosc][]" placeholder="Descripción #0"  />
					</div>
				    </td>
                                    <td>
					<div class="form-group field-proyecto-funcionesc_0 required">
					    <input type="text" id="proyecto-funcionesc_0" class="form-control" name="Proyecto[funcionesc][]" placeholder="Descripción #0"  />
					</div>
				    </td>
				    <td>
					<span class="eliminar glyphicon glyphicon-minus-sign">
					    <input type="hidden" name="Proyecto[ids][]"  />
					</span>
				    </td>
				</tr>
				<?php $i=1; ?>
			    <?php } ?>
                            <tr id='addr_1_<?= $i ?>'></tr>
                        </tbody>
                    </table>
                    <div id="add_row_1" class="btn btn-default pull-left" value="1">Agregar</div>
                    <br>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btn_colaboradores" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminaractividad');
?>
<script>
    var i=<?= $i ?>;
    $("#colaboradores_tabla").on('click','.eliminar',function(){
        var r = confirm("Estas seguro?");
        if (r == true) {
            id=$(this).children().val();
            if (id) {
		$.ajax({
                    url: '<?= $eliminaractividad ?>',
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
    });
    
    
    $("#add_row_1").click(function(){
        
        
        var objetivo=$('input[name=\'Proyecto[descripciones][]\']').length;
        /*if (objetivo==5 && $('#proyecto-actividad_objetivo1_'+(i-1)).val()!='')
        {
            $.notify({
                message: 'No se puede agregar mas de 5' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).removeClass('has-error');
            return false;
        }*/
        
        
        if($('#proyecto-descripciones_'+(i-1)).val()=='')
        {
            var error='ingrese el objetivo #'+i+' <br>';
            $('.field-proyecto-descripciones_'+(i-1)).addClass('has-error');
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
            $('.field-proyecto-descripciones_'+(i-1)).addClass('has-success');
            $('.field-proyecto-descripciones_'+(i-1)).removeClass('has-error');
            
            $('#addr_1_'+i).html("<td>"+ (i+1) +"</td><td><div class='form-group field-proyecto-descripciones_"+i+" required'><input id='proyecto-descripciones_"+i+"' name='Proyecto[descripciones][]' type='text' placeholder='Descripción #"+i+"' class='form-control'  /></div></td><td><span class='eliminar glyphicon glyphicon-minus-sign'></span></td>");
            $('#objetivos_especificos_tabla').append('<tr id="addr_1_'+(i+1)+'"></tr>');
            i++;
        }
        
        
        return true;
    });
    
    $("#btn_colaboradores").click(function(event){
	var error='';
        var objetivo1=$('input[name=\'Proyecto[descripciones][]\']').length;
        for (var i=0; i<objetivo1; i++) {
            if($('#proyecto-descripciones_'+i).val()=='')
            {
                error=error+'ingrese el objetivo especifico #'+i+'  <br>';
                $('.field-proyecto-descripciones_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-descripciones_'+i).addClass('has-success');
                $('.field-proyecto-descripciones_'+i).removeClass('has-error');
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