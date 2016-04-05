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
use app\models\Actividad;
use app\models\Cronograma;
use app\models\CultivoCrianza;
use app\models\AccionTransversal;
use app\models\Indicador;
use app\models\Colaborador;

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
        $cultivo = new CultivoCrianza();
        $AccionT = new AccionTransversal();
        
        
        $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->count();
        if($proyecto->load(Yii::$app->request->post()) )
        {
            $countObjetivosEspecificos=count(array_filter($proyecto->objetivos_descripciones));
            $countIndicadores=count(array_filter($proyecto->indicadores_descripciones));
            $countActividades=count(array_filter($proyecto->actividades_descripciones));
            $countCronogramas=count(array_filter($proyecto->cronogramas_meses));
            $countColaboradores = count(array_filter($proyecto->nombresc));
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
                
                $cultivo->id_proyecto = $proyecto->id;
                $cultivo->tipo = $proyecto->tipocc;
                $cultivo->descripcion = $proyecto->descripcioncc;
                $cultivo->save();
                
                $AccionT->id_proyecto = $proyecto->id;
                $AccionT->id_accion_transversal = $proyecto->idat;
                $AccionT->otros = $proyecto->otrosat;
                $AccionT->save();

                /*for($i=0;$i<$countObjetivosEspecificos;$i++)
>>>>>>> 696776cfe3f3faee77f470ca24c71f2d65259c77

                {
                    $objetivosespecificos=new ObjetivoEspecifico;
                    $objetivosespecificos->id_proyecto=$proyecto->id;
                    $objetivosespecificos->descripcion=$proyecto->objetivos_descripciones[$i];
                    $objetivosespecificos->save();
                }*/
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
                $data->id_tipo_proyecto = $proyecto->id_tipo_proyecto;
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
                
                $cultivo = CultivoCrianza::findOne($proyecto->idcc);
                $cultivo->id_proyecto = $proyecto->id;
                $cultivo->tipo = $proyecto->tipocc;
                $cultivo->descripcion = $proyecto->descripcioncc;
                $cultivo->update();
                
                $AccionT = AccionTransversal::findOne($proyecto->id);
                $AccionT->id_accion_transversal = $proyecto->idat;
                
                if($proyecto->idat == 15)
                $AccionT->otros = $proyecto->otrosat;
                else
                $AccionT->otros = '';
                
                $AccionT->update();
                
                

                /*objetivos*/
                for($i=0;$i<$countObjetivosEspecificos;$i++)

                {
                    if(isset($proyecto->objetivos_ids[$i]))
                    {
                        $objetivosespecificos=ObjetivoEspecifico::findOne($proyecto->objetivos_ids[$i]);
                        $objetivosespecificos->id_proyecto=$proyecto->id;
                        $objetivosespecificos->descripcion=$proyecto->objetivos_descripciones[$i];
                        $objetivosespecificos->update(); 
                    }
                    else
                    {
                        $objetivosespecificos=new ObjetivoEspecifico;
                        $objetivosespecificos->id_proyecto=$proyecto->id;
                        $objetivosespecificos->descripcion=$proyecto->objetivos_descripciones[$i];
                        $objetivosespecificos->save(); 
                    }
                }
                
                
                /*indicadores*/
                for($i=0;$i<$countIndicadores;$i++)
                {
                    //var_dump($proyecto->actividades_ids);die;
                    if(isset($proyecto->indicadores_ids[$i]))
                    {
                        $indicador=Indicador::findOne($proyecto->indicadores_ids[$i]);
                        $indicador->id_oe=$proyecto->indicadores_oe_ids[$i];
                        $indicador->descripcion=$proyecto->indicadores_descripciones[$i];
                        $indicador->update(); 
                    }
                    else
                    {
                        $indicador=new Indicador;
                        $indicador->id_oe=$proyecto->indicadores_oe_ids[$i];
                        $indicador->descripcion=$proyecto->indicadores_descripciones[$i];
                        $indicador->save(); 
                    }
                }
                
                /*actividades*/
                for($i=0;$i<$countActividades;$i++)
                {
                    //var_dump($proyecto->actividades_ids);die;
                    if(isset($proyecto->actividades_ids[$i]))
                    {
                        $actividad=Actividad::findOne($proyecto->actividades_ids[$i]);
                        $actividad->id_ind=$proyecto->actividades_ind_ids[$i];
                        $actividad->descripcion=$proyecto->actividades_descripciones[$i];
                        $actividad->update(); 
                    }
                    else
                    {
                        $actividad=new Actividad;
                        $actividad->id_ind=$proyecto->actividades_ind_ids[$i];
                        $actividad->descripcion=$proyecto->actividades_descripciones[$i];
                        $actividad->save(); 
                    }
                }
                
                /*cronogramas*/
                for($i=0;$i<$countCronogramas;$i++)
                {
                    //var_dump($proyecto->cronogramas_meses);die;
                    if(isset($proyecto->cronogramas_ids[$i]))
                    {
                        $cronograma=Cronograma::findOne($proyecto->cronogramas_ids[$i]);
                        $cronograma->id_actividad=$proyecto->cronogramas_actividad_ids[$i];
                        $cronograma->mes=$proyecto->cronogramas_meses[$i];
                        $cronograma->update(); 
                    }
                    else
                    {
                        $cronograma=new Cronograma;
                        $cronograma->id_actividad=$proyecto->cronogramas_actividad_ids[$i];
                        $cronograma->mes=$proyecto->cronogramas_meses[$i];
                        $cronograma->save(); 
                    }
                }
                
                /*colaboradores*/
                for($i=0;$i<$countColaboradores;$i++)
                {
                    //var_dump($proyecto->cronogramas_meses);die;
                    if(isset($proyecto->colaboradores_ids[$i]))
                    {
                        $Colaborador=Colaborador::findOne($proyecto->colaboradores_ids[$i]);
                        $Colaborador->id_proyecto=$proyecto->id;
                        $Colaborador->nombres=$proyecto->nombresc[$i];
                        $Colaborador->apellidos=$proyecto->apellidosc[$i];
                        $Colaborador->funcion=$proyecto->funcionesc[$i];
                        $Colaborador->update(); 
                    }
                    else
                    {
                        $Colaborador=new Colaborador;
                        $Colaborador->id_proyecto=$proyecto->id;
                        $Colaborador->nombres=$proyecto->nombresc[$i];
                        $Colaborador->apellidos=$proyecto->apellidosc[$i];
                        $Colaborador->funcion=$proyecto->funcionesc[$i];
                        $Colaborador->save(); 
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
            $cultivo =  CultivoCrianza::find()
                        ->where('id_proyecto = :id_proyecto',[':id_proyecto'=>$proyecto->id])
                        ->one();
            
            $cultivo =  CultivoCrianza::find()
                        ->where('id_proyecto = :id_proyecto',[':id_proyecto'=>$proyecto->id])
                        ->one();
           // var_dump($cultivo); die;
           
            $AccionT =  AccionTransversal::find()
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
        
        
        return $this->render('nuevo',['proyecto'=>$proyecto,'responsable'=>$responsable,'cultivo'=>$cultivo,'AccionT'=>$AccionT]);
      
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
    
    public function actionEliminarobjetivoespecifico($id)
    {
        ObjetivoEspecifico::findOne($id)->delete();
    }
    
    
    public function actionEliminaractividad($id)
    {
        Actividad::findOne($id)->delete();
    }
    
    public function actionEliminarcronograma($id)
    {
        Cronograma::findOne($id)->delete();
    }
    

}