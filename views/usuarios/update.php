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
    <input type="hidden" id="usuarios-id" name="Usuarios[id]" value="<?= $usuarios->id; ?>" />
    <div class="col-xs-12 col-sm-7 col-md-10" >
                <div class="form-group field-usuarios-Name required">
                <label for="usuarios-Name">Nombre Completo:</label>
                <input class="form-control" type="text" id="usuarios-Name" " placeholder="Nombre completo de la Persona" name="Usuarios[Name]" value="<?= $usuarios->Name; ?>" required/> <!-- required-->
                </div>    
    </div>
    <div class="col-xs-12 col-sm-7 col-md-2" >
                <div class="form-group field-usuarios-estado required">
                <label for="usuarios-estado">Estado:</label>
                <select class="form-control" id="usuarios-estado" "  name="Usuarios[estado]" >
                    <option value="1" <?= ($usuarios->estado == 1) ? 'selected':''; ?>>Activo</option>
                    <option value="0" <?= ($usuarios->estado == 0) ? 'selected':''; ?>>Inactivo</option>
                </select>
                </div>    
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-usuarios-username required">
                <label for="usuarios-username">Usuario:</label>
                <input class="form-control" type="text" id="usuarios-username" " placeholder="Nombre de Usuario" name="Usuarios[username]" value="<?= $usuarios->username; ?>" required/> <!-- required-->
                </div>    
    </div>
    <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-usuarios-password required">
                <label for="usuarios-password">Contraseña:</label>
                <input class="form-control" type="text" id="usuarios-password" " placeholder="Ingrese Contraseña" name="Usuarios[password]" value="<?= $usuarios->password; ?>" required/> <!-- required-->
                </div>    
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-7 col-md-6" >
    <input type="hidden" id="usuarios-id_perfil2" name="Usuarios[id_perfil2]" value="<?= $usuarios->id_perfil; ?>" />
                <div class="form-group field-usuarios-id_perfil required">
                <label for="usuarios-id_perfil">Perfil:</label>
                <select class="form-control" id="usuarios-id_perfil" "  name="Usuarios[id_perfil]" >
                    <?php foreach($perfil as $perfil2){ ?>
                    <option value="<?= $perfil2->id ?>" <?= ($usuarios->id_perfil == $perfil2->id) ? 'selected':''; ?>><?= $perfil2->descripcion ?></option>
                    <?php } ?>
                </select>
                </div>    
    </div>
    <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-usuarios-img">
                <label for="usuarios-img">Nombre Archivo Imagen:</label>
                <input class="form-control" type="text" id="usuarios-img" " placeholder="Nombre y extensión de Imagen para Perfil" name="Usuarios[img]" value="<?= $usuarios->img; ?>" /> <!-- required-->
                </div>    
    </div>
    <div class="clearfix"></div><br/>
    <input type="hidden" id="usuarios-nuevo_proyecto" name="Usuarios[nuevo_proyecto]" value="0" />
    <div class="col-xs-12 col-sm-7 col-md-12" id="titulo-proyecto">
                <div class="form-group field-usuarios-titulo required">
                <label for="usuarios-titulo">Titulo del Proyecto:</label>
                <input class="form-control" type="text" id="usuarios-titulo" " placeholder="Nombre completo de la Persona" name="Usuarios[titulo]" value="<?= $titulo_proyecto; ?>" required/> <!-- required-->
                </div>    
    </div>
    <div class="clearfix"></div><br/><br/>
    <div class="col-xs-12 col-sm-7 col-md-12 col-centered" > 
        <button type="submit" id="btnaceptar" class="btn btn-primary">Modificar</button>   
    </div>
    <?php ActiveForm::end(); ?>
</div>

<!--
<div class="usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // $this->render('_form', ['model' => $model,]) ?>

</div>
-->

<script>
 
 $(document).ready(function(){
    var id_perfil = "<?= $usuarios->id_perfil; ?>";
    
    $("#usuarios-titulo").prop("disabled",true);
    
    if (id_perfil == 2)
    {
        $("#titulo-proyecto").show();
        $("#usuarios-id_perfil").prop("disabled",true);
    }
    else
    {
        
      $("#titulo-proyecto").hide();
        $("#usuarios-titulo").prop("disabled",true);  
    }
    //

});
 
 $('#usuarios-id_perfil').change(function(){
    
   var valor = $(this).val();
   $("#usuarios-id_perfil2").val(valor)
    if(valor == 2)
    {
        $("#usuarios-nuevo_proyecto").val(1);
       $("#titulo-proyecto").show();
       $("#usuarios-titulo").prop("disabled",false);
       
    }
    else
    {
        $("#usuarios-nuevo_proyecto").val(0);
      $("#titulo-proyecto").hide();
      $("#usuarios-titulo").prop("disabled",true);
    }
});
    
</script>