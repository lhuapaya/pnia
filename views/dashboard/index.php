<script src="<?= Yii::$app->homeUrl.'distlte/js/waterbubble.js'; ?>" ></script>
<?php if($muestra_dash == 0) {  ?>
<div class="col-md-12 ">
<br/><br/><br/><br/>          
<div class="col-md-3 "></div>
<div class="col-md-5 text-center">
<h4>Bienvenido al Sistema de Gestión y Monitoreo de Proyectos para PNIA, por favor complete la información de su Proyecto.</h4>
</div>  
<div class="col-md-3 "></div>  
</div>
<?php } else {?>

<div class="col-md-12 ">
<br/><br/><br/><br/>
<div class="col-md-12 text-left">
<h4><strong>Avance Estrategico</strong></h4>
</div>
<div class="clearfix"></div>
<div class="col-xs-6 col-md-3 text-center ">
          
          <canvas id="estrategico"></canvas>

          
</div>
<div class="col-md-9 text-center" style="border-color: black; border-style: solid; border-width: 0px; background: #FAFAFA; ">
          <div class="clearfix"></div><br/>
          <?php $i = 0; foreach($objetivos as $obj){?>       
    <div class="col-md-10 text-left">
          <label><?= $obj->descripcion; ?></label>
    </div>
    <div class="col-md-2 text-left">
          <div class="clearfix">
                        <small class="pull-right">Avance <?= $total_obj[$i]; ?>%</small>
                      </div>
          <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: <?= $total_obj[$i]; ?>%;"></div>
          </div>
    </div>
    <div class="clearfix"></div>
    <?php $i++;} ?>
          <div class="clearfix"></div><br/>
          

</div>
<div class="clearfix"></div><br/><br/>



<div class="col-md-12 text-left">
<h4><strong>Avance Operativo</strong></h4>
</div>
<div class="clearfix"></div>
<div class="col-xs-6 col-md-3 text-center " id="div-canvas2">
          
          <canvas id="operativo" class="operativo"></canvas>

          
</div>
<div class="col-md-9 text-center" style="border-color: black; border-style: solid; border-width: 0px; background: #FAFAFA; ">
          <div class="clearfix"></div><br/>
          <div class="col-xs-12 col-sm-7 col-md-3" >
             <h5>Obj. Especifico:</h5>       
          </div>
          <div class="col-xs-12 col-sm-7 col-md-6" >
            <select class="form-control" name="Proyecto[id_objetivo]" id="proyecto-id_objetivo">
		<?php
                        $array1 = [];
                        $i = 0;
                           foreach($objetivos as $objetivoespecifico)
                            {
                                $array1[$i] = $objetivoespecifico->id;
                    ?>
                               <option value="<?= $objetivoespecifico->id; ?>" > <?= $objetivoespecifico->descripcion ?></option>;
                    <?php  $i++; } ?>    
		</select>    
        </div>
          <div class="col-xs-12 col-sm-7 col-md-3" >
          </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-7 col-md-3" >
             <h5>Indicador:</h5>       
          </div>
        <div class="col-xs-12 col-sm-7 col-md-6" >
            <select class="form-control" name="Proyecto[id_indicador]" id="proyecto-id_indicador">
		<?php
                        $array2 = [];
                       // $i = 0;
                           foreach($indicadores as $indicadores2)
                            {
                                
				if($indicadores2->id_oe == $array1[0])
				{
                    ?>
                               <option value="<?= $indicadores2->id; ?>" > <?= $indicadores2->descripcion ?></option>;
                    <?php  $array2[] = $indicadores2->id;
		    
				}
				//$i++;
			    } ?>    
		</select>    
        </div>
        <div class="col-xs-12 col-sm-7 col-md-3" >
          </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-7 col-md-12" >
          <HR width=100% align="center" size="2" style="border-style: solid" color="black">
          </div>
          <div class="clearfix"></div>
          <div class="col-xs-12 col-sm-7 col-md-12" id="div-actividades" >
          <?php
                           foreach($actividades as $actividades2)
                            {
                                
				if($actividades2->id_ind == $array2[0])
				{
                    ?>
                              <div class="col-xs-12 col-sm-7 col-md-12 text-left" >
                              <label>- <?= $actividades2->descripcion ?></label>
                              </div>
		    
			      <?php }
			    } ?>  
          
          </div>
</div> 

</div>



<?php }?>

  <?php
    $obtenerindicadores = Yii::$app->getUrlManager()->createUrl('proyecto/obtenerindicadores');
    $obteneractividad = Yii::$app->getUrlManager()->createUrl('dashboard/obteneractividad');
    $obtener_total_act= Yii::$app->getUrlManager()->createUrl('dashboard/obtener_total_act');
    //$refrescarrecurso = Yii::$app->getUrlManager()->createUrl('proyecto/refrescarrecursos');
    //$verf_presupuesto = Yii::$app->getUrlManager()->createUrl('proyecto/verificar_presupuesto');
    
?>

<script>
var est = <?= $total_por_est ?> / 100;
var ope = <?= $total_por_ope ?> / 100;
var fin = <?= $total_por_fin ?> / 100;


$('#estrategico').waterbubble({

  // bubble size
  radius: 80,

  // border width
  lineWidth: undefined,

  // data to present
  data: est,

  // color of the water bubble
  waterColor: 'rgba(25, 139, 201, 1)',

  // text color
  textColor: 'rgba(06, 85, 128, 0.8)',

  // custom font family
  //font: '',

  // show wave
  wave: true,

  // custom text displayed inside the water bubble
  txt: '<?= $total_por_est ?>%',

  // enable water fill animation
  animation: true
  
});

$('.operativo').waterbubble({

  // bubble size
  radius: 80,

  // border width
  lineWidth: undefined,

  // data to present
  data: ope,

  // color of the water bubble
  waterColor: 'rgba(25, 139, 201, 1)',

  // text color
  textColor: 'rgba(06, 85, 128, 0.8)',

  // custom font family
  //font: '',

  // show wave
  wave: true,

  // custom text displayed inside the water bubble
  txt: '<?= $total_por_ope ?>%',

  // enable water fill animation
  animation: true
  
});

/*
$('#financiero').waterbubble({

  // bubble size
  radius: 80,

  // border width
  lineWidth: undefined,

  // data to present
  data: fin,

  // color of the water bubble
  waterColor: 'rgba(25, 139, 201, 1)',

  // text color
  textColor: 'rgba(06, 85, 128, 0.8)',

  // custom font family
  //font: '',

  // show wave
  wave: true,

  // custom text displayed inside the water bubble
  txt: '<?= $total_por_fin ?>%',

  // enable water fill animation
  animation: true
  
});*/

function operativo()
{
  $('.operativo').waterbubble({

  // bubble size
  radius: 80,

  // border width
  lineWidth: undefined,

  // data to present
  data: ope,

  // color of the water bubble
  waterColor: 'rgba(25, 139, 201, 1)',

  // text color
  textColor: 'rgba(06, 85, 128, 0.8)',

  // custom font family
  //font: '',

  // show wave
  wave: true,

  // custom text displayed inside the water bubble
  txt: '<?= $total_por_ope ?>%',

  // enable water fill animation
  animation: true
  
});
}

$("#proyecto-id_objetivo").change(function(){
    
     var indicador = $("#proyecto-id_indicador");
     var actividad = $("#div-actividades");
     var objetivo = $(this);
     var val = null;
     
     if($(this).val() != '0')
        {
        $.ajax({
                    url: '<?= $obtenerindicadores ?>',
                    type: 'GET',
                    async: true,
                    data: {id:objetivo.val()},
                    success: function(data){
			
			
			 val = jQuery.parseJSON(data);
			
                        indicador.find('option').remove();
                        indicador.append(val.option);
			
			
			
			var id_indicador = indicador.val();
			
			    $.ajax({
			    url: '<?= $obteneractividad ?>',
			    type: 'GET',
			    async: false,
			    data: {id:id_indicador},
			    success: function(data){
				actividad.find('option').remove();
				actividad.html(data);
				
				
                                        $.ajax({
                                    url: '<?= $obtener_total_act ?>',
                                    type: 'GET',
                                    async: false,
                                    data: {id:id_indicador},
                                    success: function(data){
                                        
                                        //$("#div-canvas2").find('canvas').remove();
                                        est = data/ 100;
                                        //$("#div-canvas2").html('<canvas id="operativo"></canvas>');
                                        //window.requestAnimationFrame(waterbubble);
                                        operativo()
                                        /*$('#operativo2').waterbubble({

                                                  // bubble size
                                                  radius: 80,
                                                
                                                  // border width
                                                  lineWidth: undefined,
                                                
                                                  // data to present
                                                  data: data / 100,
                                                
                                                  // color of the water bubble
                                                  waterColor: 'rgba(25, 139, 201, 1)',
                                                
                                                  // text color
                                                  textColor: 'rgba(06, 85, 128, 0.8)',
                                                
                                                  // custom font family
                                                  //font: '',
                                                
                                                  // show wave
                                                  wave: true,
                                                
                                                  // custom text displayed inside the water bubble
                                                  txt: data+'%',
                                                
                                                  // enable water fill animation
                                                  animation: true
                                                  
                                                });*/                                       
                                        
                                    
                                    
                                    }
                                    });
                                
			    
			    
			    }
			    });
			    
			
                    }//
                });
        }
        
          
 });

 $("#proyecto-id_indicador").change(function(){
    
     var actividad = $("#div-actividades");
     var indicador = $(this);
     
     if($(this).val() != '0')
        {
        
			
			    $.ajax({
			    url: '<?= $obteneractividad ?>',
			    type: 'GET',
			    async: false,
			    data: {id:indicador.val()},
			    success: function(data){
				actividad.find('option').remove();
				actividad.html(data);
			    
			    
			    }
			    });
			
        }
 });
 

          
</script>