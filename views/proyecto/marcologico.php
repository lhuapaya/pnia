<div id="contenido" ng-app="app">

<ul class="tabs">
    <li><a href="#tab1">Objetivos</a></li>
    <li><a href="#tab2">Indicadores</a></li>
    <li><a href="#tab3">Actividades</a></li>
    <li><a href="#tab4">Recursos</a></li>
  </ul>
  <div class="clr"></div>
  <section class="block">
    <article id="tab1">
        <form name="formObjetivos">
        <div ng-controller="objetivoeCtrl">
        
        
        <div class="col-xs-12 col-sm-7 col-md-12" >
            <h5>Objetivo General</h5>
                <!--<label for="proyecto-objetivo_general">Señale Objeto General:</label>-->
                <textarea class="form-control" type="text"  placeholder="..."  rows="10" cols="80" style="margin: 0px; width: 100%; height: 40px;" id="proyecto-objetivo_general" name="Proyecto[objetivo_general]" ng-model="adatos.objetivo_general" required>{{adatos.objetivo_general}}</textarea>
        </div>
        
        <?= \app\widgets\objetivosespecificos\ObjetivosEspecificosWidget::widget(['proyecto_id'=>$proyecto->id]); ?> 
        <div id="control_boton">
                <button type="submit" ng-click="grabaroe()" id="btn_objetivos_especificos" class="btn btn-primary" ng-disabled="!formObjetivos.$valid" >Guardar</button>
        </div>
        
        </div>
        </form>
    </article>
    <article id="tab2">
      <?= \app\widgets\indicadores\IndicadoresWidget::widget(['proyecto_id'=>$proyecto->id]); ?>
    </article>
    <article id="tab3">
      <?= \app\widgets\actividades\ActividadesWidget::widget(['proyecto_id'=>$proyecto->id]); ?>
    </article>
    <article id="tab4">
      <p>Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.</p>
    </article>
  </section>
  
 </div>       
  <?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminarobjetivoespecifico');
?>
  
  <script>

  $(function(){
  $('ul.tabs li:first').addClass('active');
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