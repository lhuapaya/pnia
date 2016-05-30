<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RendicionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lista de Rendiciones');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rendicion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    if(Yii::$app->user->identity->id_perfil == 2)
        { ?>
    <p>
        <?= Html::a(Yii::t('app', 'Nueva Rendición'), ['detalle'], ['class' => 'btn btn-success']) ?>
    </p>
   <?php } ?>
   
   <div class="col-md-2"></div>
   <div class="col-md-10">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_solicitud',
            //'id_user',
            'fecha',
            
            [
                'label'=>'Estado',
                'attribute' => 'estado',
                'format'=>'raw',
                'value'=>function($data) {
                    
                    if($data->estado == 1 ){return "<span style='color:green;'><strong>COmpleto</strong><span>"; }
                    if($data->estado == 0 ){return "<span style='color:blue;'><strong>Registrado</strong><span>"; }
                    //if($data->estado == 2 ){return "<span style='color:green;'><strong>Completo</strong><span>"; }
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
             'template' => '{view}',
             'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="fa fa-search">Ver</span>', $url, [
                                'title' => Yii::t('app', 'Ver Desembolso'),
                                'class'=>'btn btn-primary btn-xs ver',
                                
                    ]);
                }
              ]
             
             ],
        ],
    ]); ?>
    </div>
    <div class="col-md-1"></div>
</div>
