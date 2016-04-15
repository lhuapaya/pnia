<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\PrincipalAsset;
use yii\web\JsExpression;
use app\models\Modulo;
use app\models\Menus;
use app\models\Usuarios;
use app\models\Proyecto;
use yii\web\Session;

$Asset = PrincipalAsset::register($this);
$baseUrl = $Asset->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
      <?= Html::csrfMetaTags() ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js" type="text/javascript"></script>
            
 <?php     header('Content-Type: text/html; charset=UTF-8');
            mb_internal_encoding('UTF-8');
?>
   <!-- <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
  <body>
<?php $this->beginBody() ?>


<div id="header">
<h1>PNIA</h1>
</div>
<div id="lateral">
<div id="user_login">
<img src="<?= Yii::$app->homeUrl.'img/admin.jpg';?>" class="user-image" alt="User Image">
<span><?= Yii::$app->user->identity->Name; ?></span>
<?= Html::a( 'Cerrar Sesión',['login/logout'],['class'=>'']); ?>
</div>
<div id="nav">
       <?php

           // if(\Yii::$app->user->can('investigador'))
           // {

            if(\Yii::$app->user->can('investigador'))
            {
                  $proyecto = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->one();
                        
                  $session = Yii::$app->session;
                  
                  $session['proyecto_id'] = $proyecto->id;
               
                $modulos=Usuarios::find()
                                    ->select('modulo.id mid,modulo.descripcion')
                                    ->innerJoin('perfil','perfil.id = usuarios.id_perfil')
                                    ->innerJoin('accesos','accesos.id_pefil = perfil.id')
                                    ->innerJoin('menus','menus.id = accesos.id_menu')
                                    ->innerJoin('modulo','modulo.id = menus.id_modulo')
                                    ->where('usuarios.id=:user_id and accesos.estado=1 and  modulo.estado=1 and menus.visible=1',[':user_id'=>Yii::$app->user->identity->id])
                                    ->groupBy('modulo.id,modulo.descripcion')
                                    ->all();
                                    
                foreach($modulos as $modulo)
                {
                    echo '
              <a href="#">
                <span>'.$modulo->descripcion.'</span>
              </a>
              <ul class="treeview-menu">';
                
               // var_dump($modulo->descripcion);die;
                
                $menus= Usuarios::find()
                                    ->select('menus.descripcion, menus.ruta')
                                    ->innerJoin('perfil','perfil.id = usuarios.id_perfil')
                                    ->innerJoin('accesos','accesos.id_pefil = perfil.id')
                                    ->innerJoin('menus','menus.id = accesos.id_menu')
                                    ->where('usuarios.id=:user_id and menus.estado=1 and accesos.estado=1 and menus.id_modulo=:id_modulo and menus.visible=1',[':user_id'=>Yii::$app->user->identity->id,':id_modulo'=>$modulo->mid])
                                    ->all();
                
                
                    foreach($menus as $menu)
                    {
                        echo Html::a( $menu->descripcion,[$menu->ruta],['options' => ['class' => '','id'=>'','name'=>'' ]]).'</br>';
                        /*echo Html::a( 'Datos Generales',[$menu->ruta.'#general'],['class'=>'']).'</br>';
                        echo Html::a( 'Áreas Claves',[$menu->ruta.'#areas'],['class'=>'']).'</br>';
                        echo Html::a( 'Marco Lógico',[$menu->ruta.'#logico'],['class'=>'']).'</br>';
                        echo Html::a( 'Otros',[$menu->ruta.'#otros'],['class'=>'']).'</br>';*/
                    }
                    
                    echo '</ul>';
                
                }
            
           // }
            

            }
            else if(\Yii::$app->user->can('administrador'))
            {
                $modulos=Usuarios::find()
                                    ->select('modulo.id mid,modulo.descripcion')
                                    ->innerJoin('perfil','perfil.id = usuarios.id_perfil')
                                    ->innerJoin('accesos','accesos.id_pefil = perfil.id')
                                    ->innerJoin('menus','menus.id = accesos.id_menu')
                                    ->innerJoin('modulo','modulo.id = menus.id_modulo')
                                    ->where('usuarios.id=:user_id and accesos.estado=1 and  modulo.estado=1 and menus.visible=1',[':user_id'=>Yii::$app->user->identity->id])
                                    ->groupBy('modulo.id,modulo.descripcion')
                                    ->all();
                                    
                foreach($modulos as $modulo)
                {
                    echo '
              <a href="#">
                <span>'.$modulo->descripcion.'</span>
              </a>
              <ul class="treeview-menu">';
                
               // var_dump($modulo->descripcion);die;
                
                $menus= Usuarios::find()
                                    ->select('menus.descripcion, menus.ruta')
                                    ->innerJoin('perfil','perfil.id = usuarios.id_perfil')
                                    ->innerJoin('accesos','accesos.id_pefil = perfil.id')
                                    ->innerJoin('menus','menus.id = accesos.id_menu')
                                    ->where('usuarios.id=:user_id and menus.estado=1 and accesos.estado=1 and menus.id_modulo=:id_modulo and menus.visible=1',[':user_id'=>Yii::$app->user->identity->id,':id_modulo'=>$modulo->mid])
                                    ->all();
                
                
                    foreach($menus as $menu)
                    {
                        echo Html::a( $menu->descripcion,[$menu->ruta],['options' => ['class' => '','id'=>'','name'=>'' ]]).'</br>';
                        /*echo Html::a( 'Datos Generales',[$menu->ruta.'#general'],['class'=>'']).'</br>';
                        echo Html::a( 'Áreas Claves',[$menu->ruta.'#areas'],['class'=>'']).'</br>';
                        echo Html::a( 'Marco Lógico',[$menu->ruta.'#logico'],['class'=>'']).'</br>';
                        echo Html::a( 'Otros',[$menu->ruta.'#otros'],['class'=>'']).'</br>';*/
                    }
                    
                    echo '</ul>';
                
                }
            }

            
            
            ?>

</div>
</div>
<div id="section">
<?= $content ?>
</div>


<!--<div id="footer">
Copyright © W3Schools.com
</div>
-->    
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
