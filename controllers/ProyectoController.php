<?php

namespace app\controllers;
use yii;
use yii\web\Controller;
use yii\web\Session;
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
use app\models\ZonaAccion;

class ProyectoController extends Controller
{
    
    public function behaviors()
    {
         return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','nuevo','marcologico','datosgenerales','recursos'],
                'rules' => [
                    [
                        'actions' => ['index','nuevo','marcologico','datosgenerales','recursos'],
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

            }
            else
            {
                //var_dump($proyecto->id);
                $data= Proyecto::findOne($proyecto->id);
                $data->titulo = $proyecto->titulo;
                $data->id_direccion_linea = $proyecto->id_direccion_linea;
                $data->id_unidad_ejecutora = $proyecto->id_unidad_ejecutora;
                $data->id_dependencia_inia = $proyecto->id_dependencia_inia;
                $data->resumen_ejecutivo = $proyecto->resumen_ejecutivo;
                $data->relevancia = $proyecto->relevancia;
                $data->update();
                
                
                $responsable = Responsable::findOne($proyecto->id);
                $responsable->nombres = $proyecto->nombres;
                $responsable->apellidos = $proyecto->apellidos;
                $responsable->telefono = $proyecto->telefono;
                $responsable->celular = $proyecto->celular;
                $responsable->correo = $proyecto->correo;
                
                $responsable->update();

 
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
                        
        }
        
        
        
        return $this->render('datosgenerales',['proyecto'=>$proyecto,'responsable'=>$responsable]);
      
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
            if($existe == 0)
            {
                
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
                $data->id_tipo_proyecto = $proyecto->id_tipo_proyecto;
                $data->desc_tipo_proy = $proyecto->desc_tipo_proy;
                $data->update();
                
                $cultivo = CultivoCrianza::findOne($proyecto->idcc);
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

        
        
        $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->count();
        if($proyecto->load(Yii::$app->request->post()) )
        {
            $countZonaAccion=count(array_filter($proyecto->zona_departamento));
            if($existe == 0)
            {

            }
            else
            {
                //var_dump($proyecto->id);
                $data= Proyecto::findOne($proyecto->id);
                $data->plan_trabajo = $proyecto->plan_trabajo;
                $data->resultados_esperados = $proyecto->resultados_esperados;
                $data->presupuesto = $proyecto->presupuesto;
                $data->referencias_bibliograficas = $proyecto->referencias_bibliograficas;
                $data->update();

                
                

                /*ZOna Accion*/
                for($i=0;$i<$countZonaAccion;$i++)

                {
                    if(isset($proyecto->zona_ids[$i]))
                    {
                        $zonaAccion=ZonaAccion::findOne($proyecto->zona_ids[$i]);
                        $zonaAccion->id_distrito=$proyecto->zona_distrito[$i];
                        $zonaAccion->update(); 
                    }
                    else
                    {
                        $zonaAccion=new ZonaAccion;
                        $zonaAccion->id_proyecto=$proyecto->id;
                        $zonaAccion->id_distrito=$proyecto->zona_distrito[$i];
                        $zonaAccion->save(); 
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
                        
        }
        
        
        
        return $this->render('otros',['proyecto'=>$proyecto]);
      
    }
    
    public function actionRecursos()
    {
        $this->layout='principal';
        $proyecto = new Proyecto();
        
        $session = Yii::$app->session;
        
        
        $proyecto = Proyecto::find()
                        ->where('estado = 1 and id =:id_proyecto',[':id_proyecto'=>$session['proyecto_id']])
                        ->one();
        
        
        return $this->render('recursos',['proyecto'=>$proyecto]);
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
        //var_dump($_REQUEST);die;
        $mesaje = "";
        $myData = json_decode($_POST['obj_esp']);
        
        $validarIndicador = Indicador::find()->where('id_oe = :id_oe',[':id_oe'=>$myData->id])->all();
        //var_dump($validarIndicador);die;
        //var_dump($validarIndicador);
        if($validarIndicador)
        {
           //ObjetivoEspecifico::findOne($myData->id)->delete();
           $mesaje = "El Objetivo se encuentra asociado a un Indicador";

        }
        else
        {
            ObjetivoEspecifico::findOne($myData->id)->delete();
        }
        //var_dump($mesaje);die;
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
        $option = '<option value="0">--Seleccione--</option>';
       $provincia = Ubigeo::find('province_id, province')
                            ->where('department_id = :department_id',[':department_id'=>$id])
                            ->groupBy('province')
                            ->orderBy('province')
                            ->all();
                            
        foreach($provincia as $provincias)
        {
           $option .= '<option value="'.$provincias->province_id.'" >'.$provincias->province.'</option>';
        }
        
        echo $option;
    }
    
    public function actionObtenerdistrito($id)
    {
        $option = '<option value="0">--Seleccione--</option>';
       $distritos = Ubigeo::find('district_id, district')
                            ->where('province_id = :province_id',[':province_id'=>$id])
                            ->groupBy('district')
                            ->orderBy('district')
                            ->all();
                            
        foreach($distritos as $distrito)
        {
           $option .= '<option value="'.$distrito->district_id.'" >'.$distrito->district.'</option>';
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
    
    public function actionEliminarcolaborador($id)
    {
        //$mesaje = "No existe el Identificador del Colaborador";
        
       // $validarColaborador = Colaborador::find()->where('id = :id_co',[':id_co'=>$colaborador])->all();
        
        //var_dump($validarIndicador);
        //if(isset($validarColaborador))
        //{
           Colaborador::findOne($id)->delete();
           $mesaje = "Se elimino Colaborador Correctamente";
        //}
        
        echo $mesaje;
        
        /*if(ObjetivoEspecifico::findOne($myData->id)->delete())
        {
            
        }
        else
        {
            echo "El Objetivo se encuentra asociado a un Indicador";
        }*/
        
        
    }
    
    public function actionEliminarubigeo($id)
    {

           ZonaAccion::findOne($id)->delete();
           $mesaje = "Se elimino la Zona de Acción";
        
        echo $mesaje;

        
    }

}