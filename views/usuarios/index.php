<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UbigeoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear usuario', ['nuevo'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'Name',
            'username',
            'password',
            [
                'label'=>'Perfil',
                'attribute' => 'id_perfil',
                'format'=>'raw',
                'value'=>function($data) {
                    return $data->perfil->descripcion;
                },
                //'width'=>'110px',
            ],
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update} {delete}',],
        ],
    ]); ?>

</div>
