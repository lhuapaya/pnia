<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'contact_form'] ]); ?>
    <div>
        <ul>
            <li>
                <h2>1. Datos de Usuarios</h2>
                <span class="required_notification">* Datos requeridos</span>
            </li>
            <li>
                <div class="form-group field-usuarios-Name required">
                    <label for="usuarios-Name">Nombre de usuario:</label>
                    <input type="text" value="<?= $model->Name ?>" placeholder="Nombre de usuario" id="usuarios-Name" name="Usuarios[Name]"  required/> <!-- required-->
                </div>
            </li>
            <li>
                <div class="form-group field-usuarios-username required">
                    <label for="usuarios-username">Usuario:</label>
                    <input type="text" value="<?= $model->username ?>" placeholder="Usuario" id="usuarios-username" name="Usuarios[username]"  required/> <!-- required-->
                </div>
            </li>
            <li>
                <label for="usuarios-username">Contraseña:</label>
                <input type="password" value="<?= $model->password ?>" placeholder="Contraseña" id="usuarios-password" name="Usuarios[password]"  required/> <!-- required-->
            </li>
            <li>
                <label for="usuarios-id_perfil">Perfil:</label>
                <select id="usuarios-id_perfil" name="Usuarios[id_perfil]" style="width:200px;">
                 <option value>--Seleccione--</option>   
                 <?php 
                    foreach($perfiles as $perfil)
                    {
                ?>
                    <option value="<?= $perfil->id; ?>" <?=($model->id_perfil == $perfil->id)?'selected':'' ?> > <?= $perfil->descripcion ?></option>;
                <?php
                    }
                ?>
                </select>
            </li>
            <li>
                <?= Html::submitButton($model->isNewRecord ? 'crear' : 'actualizar', ['id'=>'btnusuarios','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </li>
        </ul>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script>
    $("#btnusuarios").click(function( ) {
        var error='';
        if($.trim($('#usuarios-Name').val())=='')
        {
            error=error+'Ingrese Nombre de usuario<br>';
            $('.field-usuarios-Name').addClass('has-error');
        }
        if($.trim($('#usuarios-username').val())=='')
        {
            error=error+'Ingrese usuario<br>';
            $('.field-usuarios-username').addClass('has-error');
        }
        if($.trim($('#usuarios-password').val())=='')
        {
            error=error+'Ingrese password<br>';
            $('#usuarios-password').addClass('has-error');
        }
        if($.trim($('#usuarios-id_perfil').val())=='')
        {
            error=error+'Ingrese perfil<br>';
            $('#usuarios-id_perfil').addClass('has-error');
        }
        
        if(error!='')
        {
            $.notify({
                message: error 
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
</script>
