<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'Name',
            'username',
            //'password',
            //'id_perfil',
            //'perfil.descripcion',
            [
                'label'=>'Perfil',
                'attribute' => 'id_perfil',
                'format'=>'raw',
                'value'=>'perfil.descripcion',
                //'contentOptions'=>['style'=>'width: 120px;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                //'width'=>'60px',
            ],
            [
                'label'=>'Estado',
                //'attribute' => 'estado',
                'format'=>'raw',
                'value'=>function($data) {
                    if($data->estado == 0 ){return "<span style='color:red;'><strong>Inactivo</strong><span>"; }
                    if($data->estado == 1 ){return "<span style='color:green;'><strong>Activo</strong><span>"; }
                            
                    
                },
                //'contentOptions'=>['style'=>'width: 120px;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                //'width'=>'60px',
            ],
            // 'img',
            // 'estado',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update}',],
            
        ],
    ]); ?>

</div>
