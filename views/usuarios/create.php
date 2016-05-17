<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Create Usuarios';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div>
    <h3>Nuevo Usuario</h3>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-xs-12 col-sm-7 col-md-10" >
                <div class="form-group field-usuarios-Name required">
                <label for="usuarios-Name">Nombre Completo:</label>
                <input class="form-control" type="text" id="usuarios-Name" " placeholder="Nombre completo de la Persona" name="Usuarios[Name]"  required/> <!-- required-->
                </div>    
    </div>
    <div class="col-xs-12 col-sm-7 col-md-2" >
                <div class="form-group field-usuarios-estado required">
                <label for="usuarios-estado">Estado:</label>
                <select class="form-control" id="usuarios-estado" "  name="Usuarios[estado]" >
                    <option value="1">Activo</option>
                    <option value="1">Inactivo</option>
                </select>
                </div>    
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-usuarios-username required">
                <label for="usuarios-username">Usuario:</label>
                <input class="form-control" type="text" id="usuarios-username" " placeholder="Nombre de Usuario" name="Usuarios[username]"  required/> <!-- required-->
                </div>    
    </div>
    <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-usuarios-password required">
                <label for="usuarios-password">Contraseña:</label>
                <input class="form-control" type="text" id="usuarios-password" " placeholder="Ingrese Contraseña" name="Usuarios[password]"  required/> <!-- required-->
                </div>    
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-usuarios-id_perfil required">
                <label for="usuarios-id_perfil">Perfil:</label>
                <select class="form-control" id="usuarios-id_perfil" "  name="Usuarios[id_perfil]" >
                    <?php foreach($perfil as $perfil2){ ?>
                    <option value="<?= $perfil2->id ?>"><?= $perfil2->descripcion ?></option>
                    <?php } ?>
                </select>
                </div>    
    </div>
    <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-usuarios-img">
                <label for="usuarios-img">Nombre Archivo Imagen:</label>
                <input class="form-control" type="text" id="usuarios-img" " placeholder="Nombre y extensión de Imagen para Perfil" name="Usuarios[img]"  /> <!-- required-->
                </div>    
    </div>
    <div class="clearfix"></div><br/><br/>
    <div class="col-xs-12 col-sm-7 col-md-12 col-centered" > 
        <button type="submit" id="btnaceptar" class="btn btn-success">Crear Usuario</button>   
    </div>
    <?php ActiveForm::end(); ?>
</div>

<!--
<div class="usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // $this->render('_form', ['model' => $model,]) ?>

</div>
-->