<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ModificarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Modificar Proyecto');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyecto-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    if(\Yii::$app->user->can('investigador'))
            {
                ?>
    <p>
        <?= Html::a(Yii::t('app', 'Nuevo Cambio'), ['accion'], ['class' => 'btn btn-success','id'=>'nuevo_cambio']) ?>
    </p>
    <?php }?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'titulo',
            //'vigencia',
            //'ubigeo',
            //'id_direccion_linea',
            //'date_create',
            // 'id_unidad_ejecutora',
            // 'id_dependencia_inia',
            // 'id_tipo_proyecto',
            // 'desc_tipo_proy',
            // 'id_programa',
            // 'id_cultivo',
            // 'id_especie',
            // 'id_areatematica',
            // 'resumen_ejecutivo',
            // 'relevancia',
            // 'objetivo_general',
            // 'plan_trabajo',
            // 'resultados_esperados',
            // 'presupuesto',
            // 'referencias_bibliograficas',
            // 'problematica',
            // 'ind_prob',
            // 'med_prob',
            // 'sup_prob',
            // 'proposito',
            // 'ind_prop',
            // 'med_prop',
            // 'sup_prop',
            // 'user_propietario',
            // 'tipo_registro',
            // 'situacion',
            // 'estado',
            [
                //'label'=>'Estado',
                'attribute' => 'date_create',
                'format'=>'raw',
                /*'value'=>function($data) {
                    
                    if($data->situacion == 1 ){return "<span style='color:green;'><strong>Completo</strong><span>"; }
                    if($data->situacion == 0 ){return "<span style='color:red;'><strong>Pendiente</strong><span>"; }                         
                    
                },*/
                'contentOptions'=>['style'=>'width: 250px;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                //'width'=>'60px',
            ],
            [
                //'label'=>'Estado',
                'attribute' => 'situacion',
                'format'=>'raw',
                'value'=>function($data) {
                    
                    if($data->situacion == 1 ){return "<span style='color:red;'><strong>Pendiente</strong><span>"; }
                    if($data->situacion == 0 ){return "<span style='color:Orange;'><strong>Incompleto</strong><span>"; }
                    if($data->situacion == 2 ){return "<span style='color:green;'><strong>Completo</strong><span>"; }
                /*return  '<select id="accion_'.$data->id.'" class="form-control" onchange="ValorProyecto('.$data->id.')">
                            <option value=0>--Selec. Opción--</option>
                            <option value=4>Datos Generales</option>
                            <option value=5>Financiamiento</option>
                            <option value=6>Objetivos e Indicadores</option>
                            <option value=7>Actividades</option>
                            <option value=9>Recursos</option>
                        </select>';*/
                            
                    
                },
                'contentOptions'=>['style'=>'width: 120px;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                //'width'=>'60px',
            ],

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{modificardatosgen}',
             'buttons' => [
                'modificardatosgen' => function ($url, $model) /*use ($event)*/{
                    if($model->situacion != 0){$valor = 1; $icon = 'glyphicon-search';}else{$valor=2;$icon = 'glyphicon-pencil';}
                        $url .= '&event='.$valor; 
                        return Html::a('<span class="glyphicon '.$icon.'"><input type="hidden" value="'.$model->situacion.'" id="situacion" /></span>', $url, 
                        [
                            'title' => '',
                            'class'=>'ver',
                        ]);
                },
                
                /*'modificardatosgen' => function ($url, $model) {
                        $url .= '&event=2'; 
                        return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, 
                        [
                            'title' => Yii::t('app', 'Change today\'s lists'),
                        ]);
                        }*/
              ]
             
             
             ],
            ],
    ]); ?>

</div>

<?php

    $verificar_pendientes= Yii::$app->getUrlManager()->createUrl('proyecto/verificar_registros_pendientes');
?>


<script>
    
  $("#nuevo_cambio").click(function() {
        //alert("llego");
       var valor = 0; 
        $.ajax({
                    url: '<?= $verificar_pendientes ?>',
                    type: 'GET',
                    async: false,
                    //data: {unidadejecutora:unidad.val()},
                    success: function(data){
                      valor = data;
                    }
                });
        
        if (valor > 0) {
           
           $.notify({
                message: "<strong>No es posible esta Acción: </strong>Tiene un Registro de Cambio Pendiente." 
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
  
$(".ver").click(function(){
    
   var user = <?= Yii::$app->user->identity->id_perfil; ?>;
   
   
   if(user != 2)
    {
        situacion = $(this).children().children().val();
        if (situacion == 0)
        {
            $.notify({
                message: "El registro se encuentra Inconcluso."
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
    } 
        return true;
    });
    
</script>