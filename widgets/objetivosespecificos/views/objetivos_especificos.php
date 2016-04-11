
<div >
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-7 col-md-12" >
                    <h5>Objetivo especifico</h5>
                    <table class="table table-bordered" id="objetivos_especificos_tabla">
                       <!-- <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Objetivo especifico
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>-->
                        <tbody>
                            <tr ng-repeat="fdato in fdatos">
			    <td>
				<div class="form-group required">{{$index+1}}	
				    <input type="hidden"  class="form-control" placeholder="Descripción" ng-model="fdato.id" />
				    <input type="hidden"  class="form-control" placeholder="Descripción" ng-model="fdato.id_proyecto" />
				</div>
			    </td>
			    <td>
				<div class="form-group required">		
				    <input type="text"  class="form-control" placeholder="Descripción" ng-model="fdato.descripcion" name="descripcion" required
					   ng-class="{ error: formObjetivos.descripcion.$error.required && !formObjetivos.$pristine }">
				</div>
			    </td>
			    <td>
					<span class="eliminar glyphicon glyphicon-minus-sign" ng-click="removeRow(fdato.id,$index)">
					</span>
			    </td>
			    </tr>
                        </tbody>
                    </table>
                    <div id="objetivo_row_1-" class="btn btn-default pull-left" value="1" ng-click="addRow()">Agregar</div>
                    <br>
                </div>
                <div class="clearfix"></div>
            </div>

<?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminarobjetivoespecifico');
    $rutagrabaroe= Yii::$app->getUrlManager()->createUrl('objetivoe/registrar');
    $rutagrabarog= Yii::$app->getUrlManager()->createUrl('proyecto/grabarog');
    $rutaobetivoeindex= Yii::$app->getUrlManager()->createUrl('objetivoe/index');
    $rutaobteneog= Yii::$app->getUrlManager()->createUrl('objetivoe/obteneog');
    $ruraeliminaroe= Yii::$app->getUrlManager()->createUrl('proyecto/eliminarobjetivoespecifico');
?>
<script>
    var id_proyecto = <?= $proyecto_id ?>;
    var app = angular.module('app', []);
    app.controller('objetivoeCtrl', function($scope,$http) {
    
    //cargar contenido a formulario
     $scope.importar = function(){
	
	
	$http.get('<?= $rutaobetivoeindex ?>?val='+id_proyecto)
	.success(function (data) {
	    $scope.fdatos = data;
	    
            //$scope.fdatos = [{ "id":"5","descripcion":"Objetivo 1"},{ "id":"6","descripcion":"Objetivo 2"},{ "id":"7","descripcion":"Objetivo 3"}]
	    
	    console.log(data);
	    });
     }
     
     $scope.importar2 = function(){
	
	$http.get('<?= $rutaobteneog ?>?val='+id_proyecto)
	.success(function (data) {
	    $scope.adatos = data;
	    
            //$scope.fdatos = [{ "id":"5","descripcion":"Objetivo 1"},{ "id":"6","descripcion":"Objetivo 2"},{ "id":"7","descripcion":"Objetivo 3"}]
	    
	    console.log(data);
	    });
     }
     
     //agregar objetivo
     $scope.addRow = function()
     {
	//alert($parent.$index);
	$scope.fdatos.push({id:'',descripcion:''});
     }
     
     //borrar objetivo
     $scope.removeRow = function(id,posicion){
	
	var error ='';
	if (id) {
	    
	   $.post("<?= $ruraeliminaroe ?>", {'obj_esp':  JSON.stringify({"id": id})})

            .success(function(data){
		
		if (data!='') {
		    $.notify({
			message: data 
		    },{
			type: 'danger',
			z_index: 1000000,
			placement: {
			    from: 'bottom',
			    align: 'right'
			},
		    });
		}
		else
		{
		    $scope.fdatos.splice( posicion, 1 );	
		}
            }); 
	}
	else
	{$scope.fdatos.splice( posicion, 1 );	}
		
			
	};   
	
	//grabar objetivos
	$scope.grabaroe = function(){
	    
          $.post("<?= $rutagrabaroe ?>", {'obj_esp':  JSON.stringify($scope.fdatos)})

            .success(function(data){
              console.log(data);
	      //alert(data);
	      
	    $.post("<?= $rutagrabarog ?>", {'obj_gen':  JSON.stringify({'objetivo_general':$scope.adatos.objetivo_general,'id_proyecto':<?= $proyecto_id ?>})})

            .success(function(data){
              console.log(data);
	     // alert(data);
	    });

        });
	}
	
	$scope.importar();
	$scope.importar2();
	});
    
    app.controller('indicadorCtrl', function($scope,$http) {
	    
	    //var vm = this;
	    //vm.adatos = {objetivo_general:"Contenido del Objetivo General"};
	    
	 
	    
     $scope.cargarObjetivos = function(){
	
	$scope.select_oe = null
	$scope.idatos = [];
	
	$http.get('<?= $rutaobetivoeindex ?>?val='+id_proyecto)
	.success(function (data) {
	    $scope.idatos = data;
	    $scope.select_oe = $scope.idatos[1];
	    console.log(data);
	    });
	
	
     }
    //var defered = $q.defer();
    //var promise = defered.promise;
    
     

	$scope.cargarObjetivos();
	
	});

    /*angular
        .module('objetivoe', [])
        .controller('objetivoeCtrl', ['$http', controladorObjetivoe]);

    function controladorObjetivoe($http){
        var obe=this;

        //inicializo un objeto en los datos de formulario
        obe.fdatos = {};
	
	$.get("<?= $rutaobetivoeindex ?>",{proyecto_id: <?= $proyecto_id ?>})
	.success(function (response) {obe.fdatos = response.records;});

	

        // declaro la función enviar
        obe.grabarobe = function(){
          $.post("<?= $rutagrabaroe ?>", {'obj_esp':  JSON.stringify(obe.fdatos)})

            .success(function(data){
              console.log(data);
	      alert(data);
              //por supuesto podrás volcar la respuesta al modelo con algo como vm.res = res;
            });

	    
        }    
    }*/
    
    var oe=''; 
    
   /* $("#objetivos_especificos_tabla").on('click','.eliminar',function(){
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
    */
    
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
    
   /* $("#btn_objetivos_especificos").click(function(event){
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
    });*/
    
    $("#objetivos-especificos").click(function( ) {
	var id='<?= $proyecto_id ?>';
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