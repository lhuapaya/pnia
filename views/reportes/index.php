<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Usuarios');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
#w0 {
    font-size: x-small;
    }    
</style>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
<?php
$gridColumns = [
                'titulo',
                'username',
                'Name',
                'password',
                ];

echo ExportMenu::widget([
                         'dataProvider' => $dataProvider,
                         'columns' => $gridColumns
                         ]);
?>    
    
<div class="col-xs-12 col-sm-7 col-md-12" >
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Proyecto',
                'attribute' => 'titulo',
                'format'=>'raw',
                'value'=>'titulo',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            //'usuarios',
            'username',
            'Name',
            'password',
            'img',
             'id_perfil',
             'ejecutora',
             'dependencia',
             'estado',
            'presupuesto',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

</div>
