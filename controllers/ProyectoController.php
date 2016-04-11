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
use app\models\AlianzaEstrategica;
use app\models\Colaborador;
use app\models\Ubigeo;
class ProyectoController extends Controller
{
    
    public function behaviors()
    {
         return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','nuevo','marcologico','datosgenerales'],
                'rules' => [
                    [
                        'actions' => ['index','nuevo','marcologico','datosgenerales'],
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
    
    public function actionMarcologico()
    {
        $this->layout='principal';
        $proyecto = new Proyecto();
        $objetivosespecificos = null;
        $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->count();
                        
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
        return $this->render('marcologico',['proyecto'=>$proyecto,'objetivosespecificos'=>$objetivosespecificos]);
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
            $countAlianzas=count(array_filter($proyecto->alianzas_instituciones));
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

            }
            else
            {
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
                
                /*alianzas*/
                for($i=0;$i<$countAlianzas;$i++)

                {
                    if(isset($proyecto->alianzas_ids[$i]))
                    {
                        $alianza=AlianzaEstrategica::findOne($proyecto->alianzas_ids[$i]);
                        $alianza->id_proyecto=$proyecto->id;
                        $alianza->institucion=$proyecto->alianzas_instituciones[$i];
                        $alianza->descripcion=$proyecto->alianzas_descripciones[$i];
                        $alianza->nombres=$proyecto->alianzas_nombres[$i];
                        $alianza->apellidos=$proyecto->alianzas_apellidos[$i];
                        $alianza->correo=$proyecto->alianzas_correos[$i];
                        $alianza->telefono=$proyecto->alianzas_telefonos[$i];
                        $alianza->update(); 
                    }
                    else
                    {
                        $alianza=new AlianzaEstrategica;
                        $alianza->id_proyecto=$proyecto->id;
                        $alianza->institucion=$proyecto->alianzas_instituciones[$i];
                        $alianza->descripcion=$proyecto->alianzas_descripciones[$i];
                        $alianza->nombres=$proyecto->alianzas_nombres[$i];
                        $alianza->apellidos=$proyecto->alianzas_apellidos[$i];
                        $alianza->correo=$proyecto->alianzas_correos[$i];
                        $alianza->telefono=$proyecto->alianzas_telefonos[$i];
                        $alianza->save(); 
                    }
                }
                

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
    
    
    public function actionDatosgenerales()
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
        
        
        
        return $this->render('datosgenerales',['proyecto'=>$proyecto,'responsable'=>$responsable,'cultivo'=>$cultivo,'AccionT'=>$AccionT]);
      
    }
    
    public function actionAreasclaves()
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
        
        
        
        return $this->render('areasclaves',['proyecto'=>$proyecto,'responsable'=>$responsable,'cultivo'=>$cultivo,'AccionT'=>$AccionT]);
      
    }
    
    public function actionOtros()
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
        
        
        
        return $this->render('otros',['proyecto'=>$proyecto,'responsable'=>$responsable,'cultivo'=>$cultivo,'AccionT'=>$AccionT]);
      
    }
    
    public function actionGuardar()
    {

        
        return $this->redirect('nuevo');
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
    
    public function actionEliminarobjetivoespecifico()
    {
        $mesaje = "El Objetivo se encuentra asociado a un Indicador";
        $myData = json_decode($_POST['obj_esp']);
        
        $validarIndicador = Indicador::find()->where('id_oe = :id_oe',[':id_oe'=>$myData->id])->all();
        
        //var_dump($validarIndicador);
        if(!isset($validarIndicador))
        {
           //ObjetivoEspecifico::findOne($myData->id)->delete();
           $mesaje = "";
        }
        
        echo $mesaje;
        
        /*if(ObjetivoEspecifico::findOne($myData->id)->delete())
        {
            
        }
        else
        {
            echo "El Objetivo se encuentra asociado a un Indicador";
        }*/
        
        
    }
    
    
    public function actionEliminaractividad($id)
    {
        Actividad::findOne($id)->delete();
    }
    
    public function actionEliminarcronograma($id)
    {
        Cronograma::findOne($id)->delete();
    }
    
    public function actionObtenerprovincia($id)
    {
        $option = '';
       $provincia = Ubigeo::find('province_id, province')
                            ->where('department_id = :department_id',[':department_id'=>$id])
                            ->groupBy('province_id')
                            ->orderBy('province_id')
                            ->all();
                            
        foreach($provincia as $provincias)
        {
           $option .= '<option value="'.$provincias->province_id.'" >'.$provincias->province.'</option>';
        }
        
        echo $option;
    }
    
    public function actionGrabarog()
    {
        $data_obj = json_decode($_POST['obj_gen']);
        
        $proyecto=Proyecto::findOne($data_obj->id_proyecto);
                $proyecto->objetivo_general=$data_obj->objetivo_general;
                $proyecto->update();
                        
        echo'';
    }

}