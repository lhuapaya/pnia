<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

?>

<div id="contenido" ng-app="app">

<ul class="tabs">
    <li><a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/marcologico'); ?>">Objetivos</a></li>
    <li><a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/indicador') ?>">Indicadores</a></li>
    <li><a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/actividad') ?>">Actividades</a></li>
    <li><a href="#tab4">Recursos</a></li>
  </ul>
  <div class="clr"></div>
  <section class="block">
    <article id="tab4">
        <?php $form = ActiveForm::begin(['options' => ['class' => '', ]]); ?>
        <div>
        
        
        <div class="col-xs-12 col-sm-7 col-md-12" >
            <h5>Actividad</h5>
                <!--<label for="proyecto-objetivo_general">Señale Objeto General:</label>-->
            <select class="form-control" name="Proyecto[id_actividad]" id="proyecto-id_actividad">
		<?php
                        $array = [];
                        $i = 0;
                           foreach($actividades as $actividades2)
                            {
                                $array[$i] = $actividades2->id;
                    ?>
                               <option value="<?= $actividades2->id; ?>" > <?= $actividades2->descripcion ?></option>;
                    <?php  $i++; } ?>    
		</select>    
        </div>
        
        <?= \app\widgets\recursos\RecursosWidget::widget(['actividad_id'=>$array[0]]); ?> 
        
        
        </div>
         <?php ActiveForm::end(); ?>
    </article>

  </section>
  
 </div>       
  <?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminarobjetivoespecifico');
?>
  
  <script>

  $(function(){
  $('ul.tabs li:nth-child(4)').addClass('active');
  $('.block article').hide();
  $('.block article:first').show();
  $('ul.tabs li').on('click',function(){
    $('ul.tabs li').removeClass('active');
    $(this).addClass('active')
    $('.block article').hide();
    var activeTab = $(this).find('a').attr('href');
    $(activeTab).show();
    return false;
  });
})
    
  </script>