<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reporte Proyectos');
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>

<style>
#w0 {
    font-size: x-small;
    }    
</style>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


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
            [
                'label'=>'Usuario',
                'attribute' => 'username',
                'format'=>'raw',
                'value'=>'username',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'Objetivo',
                'attribute' => 'obj_esp',
                'format'=>'raw',
                'value'=>'obj_esp',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'Indicador',
                'attribute' => 'indicador',
                'format'=>'raw',
                'value'=>'indicador',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'Actividad',
                'attribute' => 'actividad',
                'format'=>'raw',
                'value'=>'actividad',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'Recurso',
                'attribute' => 'recurso',
                'format'=>'raw',
                'value'=>'recurso',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'Region',
                'attribute' => 'department',
                'format'=>'raw',
                'value'=>'department',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'U. Operativa',
                'attribute' => 'operativa',
                'format'=>'raw',
                'value'=>'operativa',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'U. Ejecutora',
                'attribute' => 'ejecutora2',
                'format'=>'raw',
                'value'=>'ejecutora2',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'D. Linea',
                'attribute' => 'linea',
                'format'=>'raw',
                'value'=>'linea',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'Aporte PNIA',
                'attribute' => 'presupuesto',
                'format'=>'raw',
                'value'=>'presupuesto',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],
            [
                'label'=>'Total Recurso',
                'attribute' => 'recurso_total',
                'format'=>'raw',
                'value'=>'recurso_total',
                //'contentOptions'=>['style'=>'width: 420px; font-size: x-small;','class'=>'text-center'], 
                'headerOptions'=>['class'=>'text-center'],
                
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<table id="tabla_download">
    <thead>
        <th>Nombre del Proyecto</th>
        <th>Usuario</th>
        <th>Objetivo</th>
        <th>Indicador</th>
        <th>Actividad</th>
        <th>Recurso</th>
        <th>Region</th>
        <th>Unidad Operativa</th>
        <th>Unidad Ejecutora</th>
        <th>Direccion Linea</th>
        <th>Aporte PNIA S/.</th>
        <th>Recursos Registrados S/.</th>
    </thead>
    <tbody>
        <?php
            foreach($proyectos as $proyecto)
            { ?>
                <tr>
                    <td><?= $proyecto->titulo ?></td>
                    <td><?= $proyecto->username ?></td>
                    <td><?= $proyecto->obj_esp ?></td>
                    <td><?= $proyecto->indicador ?></td>
                    <td><?= $proyecto->actividad ?></td>
                    <td><?= $proyecto->recurso ?></td>
                    <td><?= $proyecto->department ?></td>
                    <td><?= $proyecto->operativa ?></td>
                    <td><?= $proyecto->ejecutora2 ?></td>
                    <td><?= $proyecto->linea ?></td>
                    <td><?= $proyecto->presupuesto ?></td>
                    <td><?= $proyecto->recurso_total ?></td>
                </tr> 
        <?php  }
        ?>
    </tbody>
</table>

<div class="col-xs-12 col-sm-7 col-md-12" >
    <button id="exportar" class="btn btn-success pull-right">Exportar Reporte</button>  
    </div>
</div>


<script>
    
$(document).ready(function(){
   $("#tabla_download").hide(); 
 });   
    
$("#exportar").click(function(){
  $("#tabla_download").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Proyectos",
    filename: "Proyectos PNIA",
    fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
  }); 
});
</script>