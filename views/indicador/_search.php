<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IndicadorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicador-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_oe') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'peso') ?>

    <?= $form->field($model, 'unidad_medida') ?>

    <?php // echo $form->field($model, 'programado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
