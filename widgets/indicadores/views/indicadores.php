<?php
/*$objetivos_opciones='';
foreach($objetivos as $objetivo)
{
    $objetivos_opciones=$objetivos_opciones.'<option value="'.$objetivo->id.'">'.$objetivo->descripcion.'</option>';
}*/

?>
<div ng-controller="indicadorCtrl" >
    
    
	    <div class="col-xs-12 col-sm-10 col-md-8">
		<h5>Objetivos Especificos</h5>
		<select class="form-control" name="select_oe" id="select_oe" ng-model="select_oe" ng-options="item.id as item.descripcion for item in idatos" ng-change="selectAction()">
		    
		</select>
		
		</br>
		<table class="table">
		    <tbody>
			<tr ng-repeat="indicador in indicadores">
			    <td>
				<div class="form-group">{{$index+1}}
				asd</div>
			    </td>
			</tr>
		    </tbody>
		</table>
	    </div>
	    
            <div>
		<div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12">
		    <h5>Indicadores</h5>
                    <table class="table table-bordered table-hover" id="indicadores_tabla" border="0">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Descripción
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ind=0; ?>
			    <?php if($indicadores){ ?>
				
				<?php foreach($indicadores as $indicador){?>
				    <tr id='indicador_addr_1_<?= $ind ?>'>
					<td>
					<?= ($ind+1) ?>
					</td>
					<!--<td>
					    <div class="form-group field-proyecto-indicadores_oe_ids_<?= $ind ?> required">
						<select type="text" id="proyecto-indicadores_oe_ids_<?= $ind ?>" class="form-control" name="Proyecto[indicadores_oe_ids][]" >
						    <option value>Seleccionar</option>
						    <?php foreach($objetivos as $objetivo) 
						    { ?>
							<option value="<?= $objetivo->id ?>" <?= ($objetivo->id==$indicador->id_oe)?'selected':'' ?> ><?= $objetivo->descripcion?> </option>;
						    <?php
						    }
						    ?>
						</select>
					    </div>
					</td>-->
					<td class="col-xs-6">
					    <div class="form-group field-proyecto-indicadores_descripciones_<?= $ind ?>  required ">
						<input type="text" id="proyecto-indicadores_descripciones_<?= $ind ?>" class="form-control " name="Proyecto[indicadores_descripciones][]" placeholder="Indicador #<?= ($ind+1) ?>" value="<?= $indicador->descripcion ?>" />
					    </div>
					</td>
					<td class="col-xs-1">
					    <div class="form-group field-proyecto-indicadores_pesos_<?= $ind ?>  required">
						<input type="text" id="proyecto-indicadores_pesos_<?= $ind ?>" class="form-control" name="Proyecto[indicadores_pesos][]" placeholder="Peso" value="<?= $indicador->peso ?>" />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-indicadores_unidad_medidas_<?= $ind ?> required">
						<input type="text" id="proyecto-indicadores_unidad_medidas_<?= $ind ?>" class="form-control" name="Proyecto[indicadores_unidad_medidas][]" placeholder="Unidad de Medida " value="<?= $indicador->unidad_medida ?>" />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-indicadores_programados_<?= $ind ?> required">
						<input type="text" id="proyecto-indicadores_programados_<?= $ind ?>" class="form-control" name="Proyecto[indicadores_programados][]" placeholder="Programado" value="<?= $indicador->programado ?>" />
					    </div>
					</td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
						<input type="hidden" name="Proyecto[indicadores_ids][]" value="<?= $indicador->id ?>" />
					    </span>
					</td>
				    </tr>
				    <?php $ind++; ?>
				<?php } ?>
			    <?php }else{ ?>
				<tr id='indicador_addr_1_0'>
				    <td>
				    <?= ($ind+1) ?>
				    </td>
				    <td>
					
					<div class="form-group field-proyecto-indicadores_oe_ids_0 required">
					    <select type="text" id="proyecto-indicadores_oe_ids_0" class="form-control" name="Proyecto[indicadores_oe_ids][]" >
						<option value>Seleccionar</option>
						<?= $objetivos_opciones ?>
					    </select>
					</div>
				    </td>
				    <td>
					<div class="form-group field-proyecto-indicadores_descripciones_0 required">
					    <input type="text" id="proyecto-indicadores_descripciones_0" class="form-control" name="Proyecto[indicadores_descripciones][]" placeholder="Descripción #1"  />
					</div>
				    </td>
				    <td>
					<span class="eliminar glyphicon glyphicon-minus-sign">
					</span>
				    </td>
				</tr>
				<?php $ind=1; ?>
			    <?php } ?>
                            <tr id='indicador_addr_1_<?= $ind ?>'></tr>
                        </tbody>
                    </table>
                    <div id="indicadores_row_1" class="btn btn-default pull-left" value="1">Agregar</div>
                    <br>
                </div>
                <div class="clearfix"></div>
            </div>

</div>

<?php
    $eliminarindicador= Yii::$app->getUrlManager()->createUrl('proyecto/eliminarindicador');
    $rutaobetivoeindex= Yii::$app->getUrlManager()->createUrl('objetivoe/index');
    $indicadores= Yii::$app->getUrlManager()->createUrl('indicador/resultados');
?>
<script>
   
    var ind=<?= $ind ?>;
    
    app.controller('indicadorCtrl', function($scope,$http) {
	$scope.id_objetivo_especifico=null;
	$scope.cargarObjetivos = function(){
	
	    $scope.select_oe = null
	    $scope.idatos = [];
	    
	    $http.get('<?= $rutaobetivoeindex ?>?val='+id_proyecto).success(function (data) {
		$scope.idatos = data;
		$scope.select_oe = $scope.idatos[1];
		console.log(data);
	    });
	}
	$scope.cargarObjetivos();
	$scope.selectAction = function() {
	    $scope.id_objetivo_especifico=$scope.select_oe;
	    console.log($scope.select_oe);
	    /*$http.get('<?= $indicadores ?>?objetivo='+$scope.select_oe).success(function (data) {
		//$scope.indicadores = data;
	    });*/
	};
      console.log($scope.id_objetivo_especifico);
	/*
	$scope.indicadoresFunction = function(elemento){
	    console.log(elemento);
	    if (elemento!="") {
		$http.get('<?= $indicadores ?>?objetivo='+$('#select_oe').val()).success(function (data) {
		    $scope.indicadores = data;
		});	
	    }
	    
	}*/
	//$scope.indicadoresFunction($('#select_oe').val());
     
    });
    
    
    
    
    
    $("#indicadores_tabla").on('click','.eliminar',function(){
        var r = confirm("Estas seguro?");
        if (r == true) {
            id=$(this).children().val();
            if (id) {
		$.ajax({
                    url: '<?= $eliminarindicador ?>',
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
    
    
    $("#indicadores_row_1").click(function(){
        var error='';
        
        var objetivo=$('input[name=\'Proyecto[indicadores_descripciones][]\']').length;
        if($('#proyecto-indicadores_oe_ids_'+(ind-1)).val()=='')
        {
            var error=error+'seleccione un objetivo #'+ind+' <br>';
            $('.field-proyecto-indicadores_oe_ids_'+(ind-1)).addClass('has-error');
            
        }
	else
	{
	    $('.field-proyecto-indicadores_oe_ids_'+(ind-1)).addClass('has-success');
	    $('.field-proyecto-indicadores_oe_ids_'+(ind-1)).removeClass('has-error');
	}
	
	if($('#proyecto-indicadores_descripciones_'+(ind-1)).val()=='')
        {
            var error=error+'ingrese un indicador #'+ind+' <br>';
            $('.field-proyecto-indicadores_descripciones_'+(ind-1)).addClass('has-error');
            
        }
        else
	{
	    $('.field-proyecto-indicadores_descripciones_'+(ind-1)).addClass('has-success');
	    $('.field-proyecto-indicadores_descripciones_'+(ind-1)).removeClass('has-error');
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
            $('#indicador_addr_1_'+ind).html("<td>"+ (ind+1) +"</td>"+
				 "<td><div class='form-group field-proyecto-indicadores_oe_ids_"+ind+" required'><select id='proyecto-indicadores_oe_ids_"+ind+"' name='Proyecto[indicadores_oe_ids][]' class='form-control'><option value>Seleccionar</option>"+objetivos_opciones+"</select></div></td>"+
				 "<td><div class='form-group field-proyecto-indicadores_descripciones_"+ind+" required'><input id='proyecto-indicadores_descripciones_"+ind+"' name='Proyecto[indicadores_descripciones][]' type='text' placeholder='Descripción #"+(ind+1)+"' class='form-control'  /></div></td>"+
				 "<td><span class='eliminar glyphicon glyphicon-minus-sign'></span></td>");
            $('#indicadores_tabla').append('<tr id="indicador_addr_1_'+(ind+1)+'"></tr>');
            ind++;
        }
        
        
        return true;
    });
    
    $("#btn_indicadores").click(function(event){
	var error='';
        var objetivos=$('input[name=\'Proyecto[indicadores_oe_ids][]\']').length;
	var indicadores=$('input[name=\'Proyecto[indicadores_descripciones][]\']').length;
        
	
	for (var i=0; i<indicadores; i++) {
	    if($('#proyecto-indicadores_oe_ids_'+i).val()=='')
            {
                error=error+'seleccione un objetivo #'+i+'  <br>';
                $('.field-proyecto-indicadores_oe_ids_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-indicadores_oe_ids_'+i).addClass('has-success');
                $('.field-proyecto-indicadores_oe_ids_'+i).removeClass('has-error');
            }
	    
            if($('#proyecto-indicadores_descripciones_'+i).val()=='')
            {
                error=error+'ingrese un indicador #'+i+'  <br>';
                $('.field-proyecto-indicadores_descripciones_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-indicadores_descripciones_'+i).addClass('has-success');
                $('.field-proyecto-indicadores_descripciones_'+i).removeClass('has-error');
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
    
    $("#indicadores").click(function( ) {
	var proyecto_id='<?= $proyecto_id ?>';
	var objetivos=<?= $CountObjetivos ?> ;
	if (proyecto_id=='') {
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
	if (objetivos==0) {
	    $.notify({
                message: 'No existe objetivos listados'
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