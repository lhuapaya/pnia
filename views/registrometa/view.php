<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RegistroMeta */

$this->title = ($registroMeta->id_tipo == 1)?'Indicador':'Actividad';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registro Metas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-meta-view">
    <br/><br/>
    <label><strong></strong>Tipo de Registro: </strong><?= Html::encode($this->title) ?></label>

<div class="clearfix"></div><br/>
                <div class="col-xs-12 col-sm-7 col-md-2"></div>
                <div class="col-xs-12 col-sm-7 col-md-8">
		   
                    <table class="table table-striped table-bordered" id="ejecutado_table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                 <?= ($registroMeta->id_tipo == 1)?'Indicador':'Actividad' ?>
                                </th>
				<th class="text-center">
                                    Ejecutado
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>
                            <?php foreach($registroMetaDet as $registroMetaDet2){ ?>
                            <tr id='ejecutado_addr_0'>
                                <td><?= $i ?></td>
                                <td><?= $registroMetaDet2->des_indact ?></td>
                                <td class="text-center"><?= $registroMetaDet2->cantidad ?></td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                    <br/><br/>
                <div class="col-xs-12 col-sm-7 col-md-2"></div>
                <div class="clearfix"></div>

</div>
