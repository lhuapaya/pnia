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
        
        $nuevo = new Proyecto();
        
        $Usuario = new Usuarios();

        $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->count();
        
        //var_dump($existe);
                        
        if($existe > 0)
        {
           $nuevo = Proyecto::find('id, titulo')
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->one();
         
        }
        
        
        return $this->render('nuevo',['nuevo'=>$nuevo]);
        //$nuevo = new Proyecto();
        
        
      /*  $model=Proyecto::find()
                    ->select('proyecto.id, proyecto.titulo, proyecto.presupuesto')
                    ->where('estado=1')
                    ->all();*/
                    
            //var_dump($countIntituciones);
        
    }
    
    public function actionGuardar()
    {
        $Usuario = new Usuario();

        $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>$Usuario->id])
                        ->count();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

}