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
use app\models\Recurso;
use app\models\Maestros;
use app\models\Aportante;

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
        

        
        
        return $this->render('nuevo',['proyecto'=>$proyecto,'responsable'=>$responsable,'cultivo'=>$cultivo,'AccionT'=>$AccionT]);
      
    }
    
    
    public function actionDatosgenerales()
    {
        $this->layout='principal';
        $flatUpdate = 0;        
        $proyecto = new Proyecto();
        $responsable = new Responsable();
        $provincias = new Ubigeo();
        $distritos = new Ubigeo();
        
        
        $existe = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->count();
        if($proyecto->load(Yii::$app->request->post()) )
        {
            $countColaboradores = count(array_filter($proyecto->aportante_colaborador));
           // $countAlianzas=count(array_filter($proyecto->alianzas_instituciones));
            if($existe == 0)
            {
                $proyecto->user_propietario = Yii::$app->user->identity->id;
                $proyecto->estado = 1;
                $proyecto->save();
               /* $responsable->id_proyecto = $proyecto->id;
                $responsable->nombres = $proyecto->nombres;
                $responsable->apellidos = $proyecto->apellidos;
                $responsable->telefono = $proyecto->telefono;
                $responsable->celular = $proyecto->celular;
                $responsable->correo = $proyecto->correo;
                $responsable->save();*/

            }
            else
            {
                //var_dump($proyecto->id);
                $data= Proyecto::findOne($proyecto->id);
                $data->titulo = $proyecto->titulo;
                $data->vigencia = $proyecto->vigencia;
                $data->id_tipo_proyecto = $proyecto->id_tipo_proyecto;
                $data->id_programa = $proyecto->id_programa;
                $data->id_cultivo = $proyecto->id_cultivo;
                $data->id_especie = $proyecto->id_especie;
                $data->id_areatematica = $proyecto->id_areatematica;
                
                $data->ubigeo = $proyecto->distrito;
                $data->id_direccion_linea = $proyecto->id_direccion_linea;
                $data->id_unidad_ejecutora = $proyecto->id_unidad_ejecutora;
                $data->id_dependencia_inia = $proyecto->id_dependencia_inia;
                $data->resumen_ejecutivo = $proyecto->resumen_ejecutivo;
                $data->relevancia = $proyecto->relevancia;
                $data->update();
                
                
               /* $responsable = Responsable::findOne($proyecto->id);
                $responsable->nombres = $proyecto->nombres;
                $responsable->apellidos = $proyecto->apellidos;
                $responsable->telefono = $proyecto->telefono;
                $responsable->celular = $proyecto->celular;
                $responsable->correo = $proyecto->correo;
                
                $responsable->update();*/

 
                /*colaboradores*/
                for($i=0;$i<$countColaboradores;$i++)
                {
                    //var_dump($proyecto->cronogramas_meses);die;
                    if(isset($proyecto->colaboradores_ids[$i]))
                    {
                        $Colaborador=Aportante::findOne($proyecto->colaboradores_ids[$i]);
                        $Colaborador->id_proyecto=$proyecto->id;
                        $Colaborador->colaborador=$proyecto->aportante_colaborador[$i];
                        $Colaborador->regimen=$proyecto->aportante_regimen[$i];
                        $Colaborador->tipo_inst=$proyecto->aportante_tipo_inst[$i];
                        $Colaborador->tipo=3;
                        $Colaborador->update(); 
                    }
                    else
                    {
                        $Colaborador=new Aportante;
                        $Colaborador->id_proyecto=$proyecto->id;
                        $Colaborador->colaborador=$proyecto->aportante_colaborador[$i];
                        $Colaborador->regimen=$proyecto->aportante_regimen[$i];
                        $Colaborador->tipo_inst=$proyecto->aportante_tipo_inst[$i];
                        $Colaborador->tipo=3;
                        $Colaborador->save(); 
                    }
                }
                
                /*Instituciones Alianza*/
               /* for($i=0;$i<$countAlianzas;$i++)

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
                }*/
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
            
            $departamentos = Ubigeo::find(['department_id', 'department'])
                        ->groupBy('department_id')
                        ->orderBy('department')
                        ->all();
                
                        
            if($proyecto->ubigeo)
            {
                $provincias = Ubigeo::find('province_id, province')
                            ->where('department_id = :department_id',[':department_id'=>substr($proyecto->ubigeo,0,2)])
                            ->groupBy('province')
                            ->orderBy('province')
                            ->all();
        
                $distritos = Ubigeo::find('district_id, district')
                            ->where('province_id = :province_id',[':province_id'=>substr($proyecto->ubigeo,0,4)])
                            ->groupBy('district')
                            ->orderBy('district')
                            ->all();
                        
            }
            
            $cultivo =  CultivoCrianza::find()
                        ->where('id_proyecto = :id_proyecto',[':id_proyecto'=>$proyecto->id])
                        ->one();
        }
        
        
        $tipoInv = Maestros::find()
                                ->where('id_padre = 16 and estado = 1')
                                ->orderBy('orden')
                                ->all();
                                
        $programa = Maestros::find()
                                ->where('id_padre = 42 and estado = 1')
                                ->orderBy('orden')
                                ->all();
        
        $AccionT =  AccionTransversal::find()
                        ->where('id_proyecto = :id_proyecto',[':id_proyecto'=>$proyecto->id])
                        ->one();
        
        
        return $this->render('datosgenerales',['proyecto'=>$proyecto,'responsable'=>$responsable,'departamentos'=>$departamentos,'provincias'=>$provincias,'distritos'=>$distritos,'tipoInv'=>$tipoInv,'AccionT'=>$AccionT,'programa'=>$programa,'cultivo'=>$cultivo]);
      
    }
    
    
    public function actionObjetivo_indicador()
    {
        $this->layout='principal';
        $flatUpdate = 0;        
        $proyecto = new Proyecto();
        $objetivosespecificos = new ObjetivoEspecifico();
        $session = Yii::$app->session;
        
        $existe = Proyecto::find()
                        ->where('estado = 1 and id =:id',[':id'=>$session['proyecto_id']])
                        ->count();
        if($proyecto->load(Yii::$app->request->post()) )
        {
            // var_dump($_REQUEST);die;
             
            $countObjetivosEspecificos=count(array_filter($proyecto->objetivos_descripciones));
            $countIndicadores=count(array_filter($proyecto->indicadores_oe_ids));
            
            //var_dump($proyecto->indicadores_oe_ids);die;
            
            if($existe == 0)
            {
                $proyecto->user_propietario = Yii::$app->user->identity->id;
                $proyecto->estado = 1;
                $proyecto->save();

            }
            else
            {
                //var_dump($proyecto->id);
                $data= Proyecto::findOne($proyecto->id);
                $data->objetivo_general = $proyecto->objetivo_general;
                $data->update();


                /*objetivos*/
                for($i=0;$i<$countObjetivosEspecificos;$i++)

                {
                    if(isset($proyecto->objetivos_ids[$i]))
                    {
                        $objetivosespecificos=ObjetivoEspecifico::findOne($proyecto->objetivos_ids[$i]);
                        $objetivosespecificos->id_proyecto=$proyecto->id;
                        $objetivosespecificos->descripcion=$proyecto->objetivos_descripciones[$i];
                        $objetivosespecificos->peso=$proyecto->objetivos_peso[$i];
                        $objetivosespecificos->update(); 
                    }
                    else
                    {
                        $objetivosespecificos=new ObjetivoEspecifico;
                        $objetivosespecificos->id_proyecto=$proyecto->id;
                        $objetivosespecificos->descripcion=$proyecto->objetivos_descripciones[$i];
                        $objetivosespecificos->peso=$proyecto->objetivos_peso[$i];
                        $objetivosespecificos->save(); 
                    }
                }
                
                /*indicadores*/
                for($i=0;$i<$countIndicadores;$i++)
                {
                   
                    
                    if(isset($proyecto->indicadores_ids[$i]))
                    {
                        $indicador=Indicador::findOne($proyecto->indicadores_ids[$i]);
                        $indicador->id_oe=$proyecto->indicadores_oe_ids[$i];
                        $indicador->descripcion=$proyecto->indicadores_descripciones[$i];
                        $indicador->peso=$proyecto->indicadores_pesos[$i];
                        $indicador->unidad_medida=$proyecto->indicadores_unidad_medidas[$i];
                        $indicador->meta=$proyecto->indicadores_meta[$i];
                        $indicador->update(); 
                    }
                    else
                    {
                        
                        $indicador=new Indicador;
                        $indicador->id_oe=$proyecto->indicadores_oe_ids[$i];
                        $indicador->descripcion=$proyecto->indicadores_descripciones[$i];
                        $indicador->peso=$proyecto->indicadores_pesos[$i];
                        $indicador->unidad_medida=$proyecto->indicadores_unidad_medidas[$i];
                        $indicador->meta=$proyecto->indicadores_meta[$i];
                        $indicador->save();
                        
                       /* $indicador=new Indicador;
                        $indicador->id_oe=5;
                        $indicador->descripcion="123";
                        $indicador->peso=34;
                        $indicador->unidad_medida=34;
                        $indicador->meta="luis";
                        $indicador->save(); */
                    }
                }
                
            }
            
            return $this->refresh();
        }
        
                        
        if(!$proyecto->load(Yii::$app->request->post()) && $existe > 0)
        {
           $proyecto = Proyecto::find()
                        ->where('estado = 1 and id =:id',[':id'=>$session['proyecto_id']])
                        ->one();
                        
            $objetivosespecificos=ObjetivoEspecifico::find()
                                ->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$proyecto->id])
                                ->all();
                                
        }
        
        
        
        return $this->render('objetivo_indicador',['proyecto'=>$proyecto,'objetivos'=>$objetivosespecificos]);
      
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
        $flat = '';
        
        
        $existe = Proyecto::find()
                        ->where('estado = 1 and id =:id_proyecto',[':id_proyecto'=>$session['proyecto_id']])
                        ->count();
                        
        if($proyecto->load(Yii::$app->request->post()) )
        {
            $countRecurso = count(array_filter($proyecto->recurso_descripcion));
            //var_dump($proyecto->recurso_ids);
            //var_dump($proyecto->recurso_descripcion);
            //die;
            if($existe == 0)
            {

            }
            else
            {
 
                
                for($i=0;$i<$countRecurso;$i++)
                {
                    $flat .= 'a';
                    if(isset($proyecto->recurso_ids[$i]))
                    {
                        $recurso=Recurso::findOne($proyecto->recurso_ids[$i]);
                        $recurso->actividad_id=$proyecto->id_actividad;
                        $recurso->clasificador_id=$proyecto->recurso_clasificador[$i];
                        $recurso->detalle=$proyecto->recurso_descripcion[$i];
                        $recurso->unidad_medida=$proyecto->recurso_unidad[$i];
                        $recurso->cantidad=$proyecto->recurso_cantidad[$i];
                        $recurso->precio_unit=$proyecto->recurso_precioun[$i];
                        $recurso->precio_total=($proyecto->recurso_precioun[$i] *  $proyecto->recurso_cantidad[$i]);
                        $recurso->update(); 
                    }
                    else
                    {
                        
                        $recurso = new Recurso;
                        $recurso->actividad_id=$proyecto->id_actividad;
                        $recurso->clasificador_id=$proyecto->recurso_clasificador[$i];
                        $recurso->detalle=$proyecto->recurso_descripcion[$i];
                        $recurso->unidad_medida=$proyecto->recurso_unidad[$i];
                        $recurso->cantidad=$proyecto->recurso_cantidad[$i];
                        $recurso->precio_unit=$proyecto->recurso_precioun[$i];
                        $recurso->precio_total=($proyecto->recurso_precioun[$i] *  $proyecto->recurso_cantidad[$i]);
                        $recurso->save(); 
                    }
                }
                //var_dump($flat);die;
            }
            
            return $this->refresh();
        }
        
                        
        if(!$proyecto->load(Yii::$app->request->post()) && $existe > 0)
        {
            $proyecto = Proyecto::find()
                        ->where('estado = 1 and id =:id_proyecto',[':id_proyecto'=>$session['proyecto_id']])
                        ->one();
            
            $objetivosespecificos=ObjetivoEspecifico::find()
                                ->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$proyecto->id])
                                ->all();
                                
            $indicadores=Indicador::find()
                                ->select('indicador.id,indicador.descripcion,indicador.id_oe')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                                ->all();
                        
           $actividades=Actividad::find()
                                ->select('actividad.id,actividad.descripcion,actividad.id_ind')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                                ->all();
                        
        }
        
        
        
        
        
        
        
        
        
        return $this->render('recursos',['proyecto'=>$proyecto,'actividades'=>$actividades,'objetivosespecificos'=>$objetivosespecificos,'indicadores'=>$indicadores]);
    }
    
    
    public function actionIndicador()
    {
        $this->layout='principal';
        $flatUpdate = 0;        
        $proyecto = new Proyecto();
        $session = Yii::$app->session;
        
        
        $existe = Proyecto::find()
                        ->where('estado = 1 and id =:id_proyecto',[':id_proyecto'=>$session['proyecto_id']])
                        ->count();
                        
        if($proyecto->load(Yii::$app->request->post()) )
        {
            $countIndicadores=count(array_filter($proyecto->indicadores_descripciones));
            if($existe == 0)
            {

            }
            else
            {
                
                /*indicadores*/
                for($i=0;$i<$countIndicadores;$i++)
                {
                    //var_dump($proyecto->actividades_ids);die;
                    if(isset($proyecto->indicadores_ids[$i]))
                    {
                        $indicador=Indicador::findOne($proyecto->indicadores_ids[$i]);
                        $indicador->id_oe=$proyecto->id_indicador;
                        $indicador->descripcion=$proyecto->indicadores_descripciones[$i];
                        $indicador->peso=$proyecto->indicadores_pesos[$i];
                        $indicador->unidad_medida=$proyecto->indicadores_unidad_medidas[$i];
                        $indicador->programado=$proyecto->indicadores_programados[$i];
                        $indicador->update(); 
                    }
                    else
                    {
                        $indicador=new Indicador;
                        $indicador->id_oe=$proyecto->id_indicador;
                        $indicador->descripcion=$proyecto->indicadores_descripciones[$i];
                        $indicador->peso=$proyecto->indicadores_pesos[$i];
                        $indicador->unidad_medida=$proyecto->indicadores_unidad_medidas[$i];
                        $indicador->programado=$proyecto->indicadores_programados[$i];
                        $indicador->save(); 
                    }
                }
                
                
            }
            
            return $this->refresh();
        }
        
                        
        if(!$proyecto->load(Yii::$app->request->post()) && $existe > 0)
        {
           $proyecto = Proyecto::find()
                        ->where('estado = 1 and id =:id_proyecto',[':id_proyecto'=>$session['proyecto_id']])
                        ->one();
                        
            $objetivos=ObjetivoEspecifico::find()->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$proyecto->id])->all();
                    
                        
        }
        
        
        
        return $this->render('indicador',['objetivos'=>$objetivos]);
      
    }
    
    
    public function actionActividad()
    {
        $this->layout='principal';
        $flatUpdate = 0;        
        $proyecto = new Proyecto();
        $session = Yii::$app->session;
        
        
        $existe = Proyecto::find()
                        ->where('estado = 1 and id =:id_proyecto',[':id_proyecto'=>$session['proyecto_id']])
                        ->count();
                        
        if($proyecto->load(Yii::$app->request->post()) )
        {
            $countActividades=count(array_filter($proyecto->actividades_descripciones));
            if($existe == 0)
            {

            }
            else
            {
                
                
                for($i=0;$i<$countActividades;$i++)
                {
                    
                    if(isset($proyecto->actividades_ids[$i]))
                    {
                        $actividad=Actividad::findOne($proyecto->actividades_ids[$i]);
                        $actividad->id_ind=$proyecto->id_indicador;
                        $actividad->descripcion=$proyecto->actividades_descripciones[$i];
                        $actividad->id_bid=$proyecto->actividades_indicadorbid[$i];
                        $actividad->peso=$proyecto->actividades_pesos[$i];
                        $actividad->unidad_medida=$proyecto->actividades_unidad_medidas[$i];
                        $actividad->programado=$proyecto->actividades_programados[$i];
                        $actividad->fecha_inicio=$proyecto->actividades_finicio[$i];
                        $actividad->fecha_fin=$proyecto->actividades_ffin[$i];
                        $actividad->update(); 
                    }
                    else
                    {
                        $actividad=new Actividad;
                        $actividad->id_ind=$proyecto->id_indicador;
                        $actividad->descripcion=$proyecto->actividades_descripciones[$i];
                        $actividad->id_bid=$proyecto->actividades_indicadorbid[$i];
                        $actividad->peso=$proyecto->actividades_pesos[$i];
                        $actividad->unidad_medida=$proyecto->actividades_unidad_medidas[$i];
                        $actividad->programado=$proyecto->actividades_programados[$i];
                        $actividad->fecha_inicio=$proyecto->actividades_finicio[$i];
                        $actividad->fecha_fin=$proyecto->actividades_ffin[$i];
                        $actividad->save(); 
                    }
                }
                
                
            }
            
            return $this->refresh();
        }
        
                        
        if(!$proyecto->load(Yii::$app->request->post()) && $existe > 0)
        {
           $proyecto = Proyecto::find()
                        ->where('estado = 1 and id =:id_proyecto',[':id_proyecto'=>$session['proyecto_id']])
                        ->one();
                        
            $objetivosespecificos=ObjetivoEspecifico::find()
                                ->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$proyecto->id])
                                ->all();
                                
            $indicadores=Indicador::find()
                                ->select('indicador.id,indicador.descripcion,indicador.id_oe')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                                ->all();
                    
                        
        }
        
        
        
        return $this->render('actividad',['indicadores'=>$indicadores,'objetivosespecificos'=>$objetivosespecificos]);
      
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
    
    public function actionEliminarindicador($id)
    {
        $mesaje = "";
        $estado = 0;
        $validaractividades = Actividad::find()->where('id_ind = :id_ind',[':id_ind'=>$id])->all();

        if($validaractividades)
        {
           $mesaje = "El Indicador se encuentra asociado con Actividades";

        }
        else
        {
            Indicador::findOne($id)->delete();
            $estado = 1;
            $mesaje = "Se elimino el Indicador Correctamente.";
        }
        
        
        
        $array = array('mensaje'=>$mesaje,'estado'=>$estado);
            echo json_encode($array);
    }
    
    public function actionEliminaractividad($id)
    {
        $mesaje = "";
        $estado = '0';
        $validarrecurso = Recurso::find()->where('actividad_id = :actividad_id',[':actividad_id'=>$id])->all();

        if($validarrecurso)
        {
           //ObjetivoEspecifico::findOne($myData->id)->delete();
           $mesaje = "La Actividad se encuentra asociado Recursos";

        }
        else
        {
            Actividad::findOne($id)->delete();
            $estado = '1';
            $mesaje = "Se elimino la Actividad Correctamente.";
        }
        
        
        
        $array = array('mensaje'=>$mesaje,'estado'=>$estado);
            echo json_encode($array);

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
           Aportante::findOne($id)->delete();
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
    
    public function actionEliminarrecurso($id)
    {

           Recurso::findOne($id)->delete();
           $mesaje = "Se elimino el Recurso Correctamente.";
        
        echo $mesaje;

        
    }
    
    public function actionRefrescarrecursos($id)
    {
        $html = '';
        $opcion1 = '';
        $re = 0;
        $recursos=Recurso::find()
                                ->where('actividad_id=:actividad_id',[':actividad_id'=>$id])
                                ->all();
        
        $clasificador = Maestros::find()
                                ->where('id_padre = 32 and estado = 1')
                                ->orderBy('orden')
                                ->all();
        

        
        if($recursos)
        {
            
            
                foreach($recursos as $recursos2)
                {
                    
                    foreach($clasificador as $clasificador2)
                    {
                                                        
                     $opcion1 .='<option value="'.$clasificador2->id.'" '.($clasificador2->id == $recursos2->clasificador_id ? 'selected="selected"' : '' ).'>'.$clasificador2->descripcion.'</option>';
                                                          
                    }

			$html .= '<tr id="recurso_addr_1_'.$re.'">
					<td>
					'.($re+1).'
                                        <input type="hidden" name="Proyecto[recurso_numero][]" id="proyecto-recurso_numero_'.$re.'" value="'.$re.'" />
					</td>
					<td>
                                        <div class="form-group field-proyecto-recurso_clasificador_'.$re.' required">
                                            <select  class="form-control " id="proyecto-recurso_clasificador_'.$re.'" name="Proyecto[recurso_clasificador][]" >
                                                <option value="0">--Clasificador--</option>'.$opcion1.'</select>
					    
                                            </div>    
                                        </td>
                                        <td class="col-xs-3"  >
                                            <div class="form-group field-proyecto-recurso_descripcion_'.$re.' required">
                                                <input class="form-control " value="'.$recursos2->detalle.'" type="text"  placeholder="..." id="proyecto-recurso_descripcion_'.$re.'" name="Proyecto[recurso_descripcion][]"/>
                                            </div>
                                        </td>
                                        <td class="col-xs-3">
                                            <div class="form-group field-proyecto-recurso_unidad_'.$re.' required">
                                                <input class="form-control " value="'.$recursos2->unidad_medida.'" type="text"  placeholder="..." id="proyecto-recurso_unidad_'.$re.'" name="Proyecto[recurso_unidad][]"/>
                                            </div>
                                        </td>
                                        <td class="col-xs-1">
                                            <div class="form-group field-proyecto-recurso_cantidad_'.$re.' required">
                                                <input  class="form-control " value="'.$recursos2->cantidad.'" class="form-control " type="text"  placeholder="..." id="proyecto-recurso_cantidad_'.$re.'" name="Proyecto[recurso_cantidad][]"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group field-proyecto-recurso_precioun_'.$re.' required">
                                                <input class="form-control " value="'.$recursos2->precio_unit.'" class="form-control "  type="text"  placeholder="..." id="proyecto-recurso_precioun_'.$re.'" name="Proyecto[recurso_precioun][]"/>
                                            </div>
                                        </td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
						<input type="hidden" name="Proyecto[recurso_ids][]" value="'.$recursos2->id.'" />
					    </span>
					</td>
				    </tr>';
				     $re++;
		}
        }
        else
        {
            foreach($clasificador as $clasificador2)
            {
                                                
             $opcion1 .='<option value="'.$clasificador2->id.'" >'.$clasificador2->descripcion.'</option>';
                                                  
            }
            
         $html .='<tr id="recurso_addr_1_0">
				    <td>
				    '.($re+1).'
                                    <input type="hidden" name="Proyecto[recurso_numero][]" id="proyecto-recurso_numero_'.$re.'" value="'.$re.'" />
				    </td>
				    <td class="col-xs-2" >
					<div class="form-group field-proyecto-recurso_clasificador_0 required">
                                            <select  class="form-control " id="proyecto-recurso_clasificador_0" name="Proyecto[recurso_clasificador][]" >
                                                <option value="0">--Clasificador--</option>'.$opcion1.'</select>
					    
					</div>
				    </td>
                                    <td class="col-xs-3"  >
					<div class="form-group field-proyecto-recurso_descripcion_0 required">
					    <input class="form-control " type="text"  placeholder="..." id="proyecto-recurso_descripcion_0" name="Proyecto[recurso_descripcion][]"/>
					</div>
				    </td>
                                    <td class="col-xs-3">
					<div class="form-group field-proyecto-recurso_unidad_0 required">
					    <input class="form-control " type="text"  placeholder="..." id="proyecto-recurso_unidad_0" name="Proyecto[recurso_unidad][]"/>
					</div>
				    </td>
                                    <td class="col-xs-1">
					<div class="form-group field-proyecto-recurso_cantidad_0 required">
					    <input  class="form-control " class="form-control " type="text"  placeholder="..." id="proyecto-recurso_cantidad_0" name="Proyecto[recurso_cantidad][]"/>
					</div>
				    </td>
                                    <td>
					<div class="form-group field-proyecto-recurso_precioun_0 required">
					    <input class="form-control " class="form-control "  type="text"  placeholder="..." id="proyecto-recurso_precioun_0" name="Proyecto[recurso_precioun][]"/>
					</div>
				    </td>
				    <td>
					<span class="eliminar glyphicon glyphicon-minus-sign">
					    
					</span>
				    </td>
				</tr>';
                                
                                $re = 1;
        }
        
            $html .='<tr id="recurso_addr_1_'.$re.'"></tr>';
            
            $array = array('html'=>$html,'contador'=>$re);
            //$array[] = $re;
            echo json_encode($array);
    }
    
    
    public function actionRefrescarindicadores($id)
    {
        $html = '';
        $opcion1 = '';
        $ind = 0;
        
        $indicadores=Indicador::find()
                                ->where('id_oe=:objetivo_id',[':objetivo_id'=>$id])
                                ->all();        

        
        if($indicadores)
        {
            
            
                foreach($indicadores as $indicadores2)
                {
                    


			$html .= '<tr id="indicador_addr_1_'.$ind.'">
					<td>
					'.($ind+1).'
					<input type="hidden" name="Proyecto[indicadores_numero][]" id="proyecto-indicadores_numero_'.$ind.'" value="'.$ind.'" />
					</td>

					<td class="col-xs-6">
					    <div class="form-group field-proyecto-indicadores_descripciones_'.$ind.'  required ">
						<input type="text" id="proyecto-indicadores_descripciones_'.$ind.'" class="form-control " name="Proyecto[indicadores_descripciones][]" placeholder="Indicador #'.$ind.'" value="'.$indicadores2->descripcion.'" />
					    </div>
					</td>
					<td class="col-xs-1">
					    <div class="form-group field-proyecto-indicadores_pesos_'.$ind.' required">
						<input type="text" id="proyecto-indicadores_pesos_'.$ind.'" class="form-control" name="Proyecto[indicadores_pesos][]" placeholder="Peso" value="'.$indicadores2->peso.'" />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-indicadores_unidad_medidas_'.$ind.' required">
						<input type="text" id="proyecto-indicadores_unidad_medidas_'.$ind.'" class="form-control" name="Proyecto[indicadores_unidad_medidas][]" placeholder="Unidad de Medida " value="'.$indicadores2->unidad_medida.'" />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-indicadores_programados_'.$ind.' required">
						<input type="text" id="proyecto-indicadores_programados_'.$ind.'" class="form-control" name="Proyecto[indicadores_programados][]" placeholder="Programado" value="'.$indicadores2->programado.'" />
					    </div>
					</td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
						<input type="hidden" name="Proyecto[indicadores_ids][]" value="'.$indicadores2->id.'" />
					    </span>
					</td>
				    </tr>';
				     $ind++;
		}
        }
        else
        {
            
         $html .='<tr id="indicador_addr_1_0">
				    <td>
					'.($ind+1).'
					<input type="hidden" name="Proyecto[indicadores_numero][]" id="proyecto-indicadores_numero_0" value="'.$ind.'" />
					</td>

					<td class="col-xs-6">
					    <div class="form-group field-proyecto-indicadores_descripciones_0  required ">
						<input type="text" id="proyecto-indicadores_descripciones_0" class="form-control " name="Proyecto[indicadores_descripciones][]" placeholder="Indicador #'.($ind+1).'"  />
					    </div>
					</td>
					<td class="col-xs-1">
					    <div class="form-group field-proyecto-indicadores_pesos_0  required">
						<input type="text" id="proyecto-indicadores_pesos_0" class="form-control" name="Proyecto[indicadores_pesos][]" placeholder="Peso"  />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-indicadores_unidad_medidas_0 required">
						<input type="text" id="proyecto-indicadores_unidad_medidas_0" class="form-control" name="Proyecto[indicadores_unidad_medidas][]" placeholder="Unidad de Medida "  />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-indicadores_programados_0 required">
						<input type="text" id="proyecto-indicadores_programados_0" class="form-control" name="Proyecto[indicadores_programados][]" placeholder="Programado"  />
					    </div>
					</td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
					    </span>
					</td>
				</tr>';
                                
                                $ind = 1;
        }
        
            $html .='<tr id="indicador_addr_1_'.$ind.'"></tr>';
            
            $array = array('html'=>$html,'contador'=>$ind);
            echo json_encode($array);
    }
    
    
    
    
    public function actionRefrescaractividades($id)
    {
        $html = '';
        $opcion1 = '';
        $act = 0;

        $actividades=Actividad::find()
                                ->where('id_ind=:id_ind',[':id_ind'=>$id])
                                ->all();
                                
        $indicadorBID = Maestros::find()
                                ->where('id_padre = 38 and estado = 1')
                                ->orderBy('orden')
                                ->all();
        

        
        if($actividades)
        {
            
            
                foreach($actividades as $actividad)
                {
                    
                    foreach($indicadorBID as $indicadorBID2)
                    {
                                                        
                     $opcion1 .='<option value="'.$indicadorBID2->id.'" '.($indicadorBID2->id == $actividad->id_bid ? 'selected="selected"' : '' ).'>'.$indicadorBID2->descripcion.'</option>';
                                                          
                    }

			$html .= '<tr id="actividad_addr_1_'.$act.'">
					<td>
					'.($act+1).'
					<input type="hidden" name="Proyecto[actividades_numero][]" id="proyecto-actividades_numero_'.$act.'" value="'.$act.'" />
					</td>
					<td class="col-xs-4">
					    <div class="form-group field-proyecto-actividades_descripciones_'.$act.' required">
						<input type="text" id="proyecto-actividades_descripciones_'.$act.'" class="form-control" name="Proyecto[actividades_descripciones][]" placeholder="" value="'.$actividad->descripcion.'" />
					    </div>
					</td>
					<td class="col-xs-1">
                                        <div class="form-group field-proyecto-actividades_indicadorbid_'.$act.' required">
                                            <select  class="form-control " id="proyecto-actividades_indicadorbid_'.$act.'" name="Proyecto[actividades_indicadorbid][]" >
                                                <option value="0">--Indicador BID--</option>'.$opcion1.'</select>
					    
                                            </div>    
                                        </td>
					<td class="col-xs-1">
					    <div class="form-group field-proyecto-actividades_pesos_'.$act.' required">
						<input type="text" id="proyecto-actividades_pesos_'.$act.'" class="form-control" name="Proyecto[actividades_pesos][]" placeholder="Peso" value="'.$actividad->peso.'" />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-actividades_unidad_medidas_'.$act.' required">
						<input type="text" id="proyecto-actividades_unidad_medidas_'.$act.'" class="form-control" name="Proyecto[actividades_unidad_medidas][]" placeholder="Unidad de Medida" value="'.$actividad->unidad_medida.'" />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-actividades_programados_'.$act.' required">
						<input type="text" id="proyecto-actividades_programados_'.$act.'" class="form-control" name="Proyecto[actividades_programados][]" placeholder="Cantidad Programada<?= $act ?>" value="'.$actividad->programado.'" />
					    </div>
					</td>
					<td>
					    <div>
					    '.\app\widgets\fechas\FechasWidget::widget(['actividad_id'=>$actividad->id,'act'=>$act]).'
					    </div>
					</td>
					<td>
					    <span class="eliminar glyphicon glyphicon-minus-sign">
						<input type="hidden" name="Proyecto[actividades_ids][]" value="'.$actividad->id.'" />
					    </span>
					</td>
				    </tr>';
				     $act++;
                                     $opcion1 = '';
		}
                
                
        }
        else
        {
            foreach($indicadorBID as $indicadorBID2)
                    {
                                                        
                     $opcion1 .='<option value="'.$indicadorBID2->id.'" >'.$indicadorBID2->descripcion.'</option>';
                                                          
                    }
            
         $html .='<tr id="actividad_addr_1_0">
				    <td>
					'.($act+1).'
					<input type="hidden" name="Proyecto[actividades_numero][]" id="proyecto-actividades_numero_0" value="0" />
					</td>
					<td class="col-xs-4">
					    <div class="form-group field-proyecto-actividades_descripciones_0 required">
						<input type="text" id="proyecto-actividades_descripciones_0" class="form-control" name="Proyecto[actividades_descripciones][]" placeholder=""  />
					    </div>
					</td>
					<td class="col-xs-1">
                                        <div class="form-group field-proyecto-actividades_indicadorbid_0 required">
                                            <select  class="form-control " id="proyecto-actividades_indicadorbid_0" name="Proyecto[actividades_indicadorbid][]" >
                                                <option value="0">--Indicador BID--</option>'.$opcion1.'</select>
					    
                                            </div>    
                                        </td>
					<td class="col-xs-1">
					    <div class="form-group field-proyecto-actividades_pesos_0 required">
						<input type="text" id="proyecto-actividades_pesos_0" class="form-control" name="Proyecto[actividades_pesos][]" placeholder="" " />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-actividades_unidad_medidas_0 required">
						<input type="text" id="proyecto-actividades_unidad_medidas_0" class="form-control" name="Proyecto[actividades_unidad_medidas][]" placeholder=""  />
					    </div>
					</td>
					<td>
					    <div class="form-group field-proyecto-actividades_programados_0 required">
						<input type="text" id="proyecto-actividades_programados_0" class="form-control" name="Proyecto[actividades_programados][]" placeholder="" />
					    </div>
					</td>
					<td>
					    <div>'.\app\widgets\fechas\FechasWidget::widget(['actividad_id'=>'','act'=>$act]).' 
					    </div>
					</td>
				    <td>
					<span class="eliminar glyphicon glyphicon-minus-sign">
					</span>
				    </td>
				</tr>';
                                
                                $act = 1;
        }
        
            $html .='<tr id="actividad_addr_1_'.$act.'"></tr>';
            
            $array = array('html'=>$html,'contador'=>$act);
            //$array[] = $re;
            echo json_encode($array);
    }
    
    
    public function actionObtenerindicadores($id)
    {
        $opcion1 = '';
        
        $indicadores=Indicador::find()
                                ->where('id_oe=:objetivo_id',[':objetivo_id'=>$id])
                                ->all();
        
        foreach($indicadores as $indicador)
            {
                                                
             $opcion1 .='<option value="'.$indicador->id.'" >'.$indicador->descripcion.'</option>';
                                                  
            }
        
       echo $opcion1; 
    }
    
    public function actionObteneractividad($id)
    {
        $opcion1 = '';
        
        $actividades=Actividad::find()
                                ->where('id_ind=:id_ind',[':id_ind'=>$id])
                                ->all();
        
        foreach($actividades as $actividad)
            {
                                                
             $opcion1 .='<option value="'.$actividad->id.'" >'.$actividad->descripcion.'</option>';
                                                  
            }
        
       echo $opcion1; 
    }
    

}