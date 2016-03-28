<?php

namespace app\controllers;
use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Usuarios;
use app\models\Proyecto;

class ProyectoController extends Controller
{
    
    public function behaviors()
    {
         return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','nuevo'],
                'rules' => [
                    [
                        'actions' => ['index','nuevo'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];

    }

    
    public function actionIndex()
    {
        
        //$model = new Proyecto();
        $this->layout='principal';
        $model=Proyecto::find()
                    ->select('proyecto.id, proyecto.titulo, proyecto.presupuesto')
                    ->where('estado=1')
                    ->all();
                    
            //var_dump($countIntituciones);
        return $this->render('index',['model'=>$model]);
    }
    
    public function actionNuevo()
    {
        $this->layout='principal';
        
        //$model = new Proyecto();
        
      /*  $model=Proyecto::find()
                    ->select('proyecto.id, proyecto.titulo, proyecto.presupuesto')
                    ->where('estado=1')
                    ->all();*/
                    
            //var_dump($countIntituciones);
        return $this->render('nuevo');
    }

}