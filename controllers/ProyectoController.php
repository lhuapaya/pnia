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
use app\models\Responsable;
use app\models\ObjetivoEspecifico;

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
        $flatUpdate = 0;        
        $proyecto = new Proyecto();
        $responsable = new Responsable();
        $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->count();
        if($proyecto->load(Yii::$app->request->post()) )
        {
            $countObjetivosEspecificos=count($proyecto->descripciones);
            if($existe == 0)
            {
                $proyecto->user_propietario = Yii::$app->user->identity->id;
                $proyecto->estado = 1;
                $proyecto->save();
                $responsable->id_proyecto = $proyecto->id;
                $responsable->nombres = $proyecto->nombres;
                $responsable->apellidos = $proyecto->apellidos;
                $responsable->telefono = $proyecto->telefono;
                $responsable->celular = $proyecto->celular;
                $responsable->correo = $proyecto->correo;
                $responsable->save();
                /*estee esss*/
                for($i=0;$i<$countObjetivosEspecificos;$i++)
                {
                    $objetivosespecificos=new ObjetivoEspecifico;
                    $objetivosespecificos->id_proyecto=$proyecto->id;
                    $objetivosespecificos->descripcion=$proyecto->descripciones[$i];
                    $objetivosespecificos->save();
                }
            }
            else
            {
                //var_dump($proyecto->id);
                $data= Proyecto::findOne($proyecto->id);
                $data->titulo = $proyecto->titulo;
                $data->direccion_linea = $proyecto->direccion_linea;
                $data->estacion_exp = $proyecto->estacion_exp;
                $data->sub_estacion_exp = $proyecto->sub_estacion_exp;
                $data->sub_estacion_exp = $proyecto->sub_estacion_exp;
                $data->sub_estacion_exp = $proyecto->sub_estacion_exp;
                $data->desc_tipo_proy = $proyecto->desc_tipo_proy;
                $data->resumen_ejecutivo = $proyecto->resumen_ejecutivo;
                $data->relevancia = $proyecto->relevancia;
                $data->objetivo_general = $proyecto->objetivo_general;
                $data->plan_trabajo = $proyecto->plan_trabajo;
                $data->resultados_esperados = $proyecto->resultados_esperados;
                $data->presupuesto = $proyecto->presupuesto;
                $data->referencias_bibliograficas = $proyecto->referencias_bibliograficas;
                $data->update();
                
                
                $responsable = Responsable::findOne($proyecto->id);
                $responsable->nombres = $proyecto->nombres;
                $responsable->apellidos = $proyecto->apellidos;
                $responsable->telefono = $proyecto->telefono;
                $responsable->celular = $proyecto->celular;
                $responsable->correo = $proyecto->correo;
                
                $responsable->update();
                /*y este*/
                for($i=0;$i<$countObjetivosEspecificos;$i++)
                {
                    if(isset($proyecto->ids[$i]))
                    {
                        $objetivosespecificos=ObjetivoEspecifico::findOne($proyecto->ids[$i]);
                        $objetivosespecificos->id_proyecto=$proyecto->id;
                        $objetivosespecificos->descripcion=$proyecto->descripciones[$i];
                        $objetivosespecificos->update(); 
                    }
                    else
                    {
                        $objetivosespecificos=new ObjetivoEspecifico;
                        $objetivosespecificos->id_proyecto=$proyecto->id;
                        $objetivosespecificos->descripcion=$proyecto->descripciones[$i];
                        $objetivosespecificos->save(); 
                    }
                }
                
            }
            
            return $this->refresh();
        }
        
                        
        if(!$proyecto->load(Yii::$app->request->post()) && $existe > 0)
        {
           $proyecto = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->one();
            
           $responsable = Responsable::find()
                            ->where('id_proyecto = :id_proyecto',[':id_proyecto'=>$proyecto->id])
                            ->one();
        }
        
       /* if($proyecto->load(Yii::$app->request->post()) && ($existe == 0))
        {
            
            $proyecto->user_propietario = Yii::$app->user->identity->id;
            $proyecto->estado = 1;
            $proyecto->save();
            
            
            
            
            $idproyecto = Proyecto::find('id')
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->one();
            
            $responsable->id_proyecto = $idproyecto->id;
            $responsable->nombres = $proyecto->nombres;
            $responsable->apellidos = $proyecto->apellidos;
            $responsable->telefono = $proyecto->telefono;
            $responsable->celular = $proyecto->celular;
            $responsable->correo = $proyecto->correo;
            
            $responsable->save();
            
            //var_dump($proyecto->nombres);
        }
        
        if($proyecto->load(Yii::$app->request->post()) && ($existe > 0))
        {
            $proyecto->titulo = $proyecto->proyecto-titulo;
            $proyecto->user_propietario = Yii::$app->user->identity->id;
            $proyecto->estado = 1;
            $proyecto->save();
        }*/
        
        
        return $this->render('nuevo',['proyecto'=>$proyecto,'responsable'=>$responsable]);
      
    }
    
    public function actionGuardar()
    {
        

        $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->count();
                        
        $model = new Proyecto();
        
        if ($model->load(Yii::$app->request->post()) && ($existe == 0)) {
            
            $model->titulo = $model->proyecto-titulo;
            $model->user_propietario = Yii::$app->user->identity->id;
            $model->estado = 1;
            $model->save();
        }
        else
        {
            $model = $this->findModel($id);
            
        }
        
        return $this->redirect('nuevo', [
                'nuevo' => $model,
            ]);
    }
    
    public function actionExisteproyecto()
    {
       $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->count();
                        
        if($existe == 0)
        {
          $error = 'No Exite Proyecto Registrado!';  
        }
        else
        {
            $error = 1;
        }
        
        echo $error;
    }
    

}