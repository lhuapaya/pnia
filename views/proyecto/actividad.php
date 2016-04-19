<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

?>

<div id="contenido" ng-app="app">

<ul class="tabs">
    <li><a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/marcologico'); ?>">Objetivos</a></li>
    <li><a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/indicador') ?>">Indicadores</a></li>
    <li><a href="#tab3">Actividades</a></li>
    <li><a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/recursos') ?>">Recursos</a></li>
  </ul>
  <div class="clr"></div>
  <section class="block">
    <article id="tab3">
        <?php $form = ActiveForm::begin(['options' => ['class' => '', ]]); ?>
        <div>
        
        
        <div class="col-xs-12 col-sm-7 col-md-12" >
            <h5>Indicadores</h5>
                <!--<label for="proyecto-objetivo_general">Señale Objeto General:</label>-->
            <select class="form-control" name="Proyecto[id_indicador]" id="proyecto-id_indicador">
		<?php
                        $array = [];
                        $i = 0;
                           foreach($indicadores as $indicadores2)
                            {
                                $array[$i] = $indicadores2->id;
                    ?>
                               <option value="<?= $indicadores2->id; ?>" > <?= $indicadores2->descripcion ?></option>;
                    <?php  $i++; } ?>    
		</select>    
        </div>
        
        <?= \app\widgets\actividades\ActividadesWidget::widget(['indicador_id'=>$array[0]]); ?> 
        
        
        </div>
         <?php ActiveForm::end(); ?>
    </article>

  </section>
  
 </div>       

  
  <script>

  $(function(){
  $('ul.tabs li:nth-child(3)').addClass('active');
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