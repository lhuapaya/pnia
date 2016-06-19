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
use app\models\ObjetivoEspecifico;
use app\models\Indicador;
use app\models\Actividad;
class DashboardController extends Controller
{
    
    public function behaviors()
    {
         return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];

    }

    
    public function actionIndex()
    {
        $this->layout='principal';
        $total_por_est = 0;
        $total_por_ope = 0;
        $total_por_fin = 0;
        $total_obj = [];
        $objetivos = new ObjetivoEspecifico();
        $indicadores = new Indicador();
        $actividades = new Actividad();
        
        $muestra_dash = 0;
        
       if(Yii::$app->user->identity->id_perfil == 2)
       {
        $proyecto = Proyecto::find()
                        ->where('estado = 1 and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                        ->one();
        
                        
        if(($proyecto->estado == 1) && ($proyecto->situacion == 2))
        {
           $muestra_dash = 1;
           
           $objetivos = ObjetivoEspecifico::find()
                            ->where('id_proyecto = :id_proyecto',[":id_proyecto"=>$proyecto->id])
                            ->orderBy(['gestion'=>SORT_ASC,'descripcion'=>SORT_ASC])
                            ->all();
            $i = 0;
            foreach($objetivos as $obj)
            {
               $sumat_ind=Indicador::find()
                                ->select('sum(indicador.meta) as meta,sum(indicador.ejecutado) as ejecutado')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->where('indicador.id_oe=:id_oe',[':id_oe'=>$obj->id])
                                ->all();
                                
                foreach($sumat_ind as $sumt_ind)                    
                $total_obj[$i] = ($sumt_ind->ejecutado * 100) / $sumt_ind->meta;
                $i++;
            }
            
            $sumatoatal_ind=Indicador::find()
                                ->select('sum(indicador.meta) as meta,sum(indicador.ejecutado) as ejecutado')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                                ->all();
            foreach($sumatoatal_ind as $sumtoatal_ind)                    
            $total_por_est = ($sumtoatal_ind->ejecutado * 100) / $sumtoatal_ind->meta;
            
            
            $indicadores=Indicador::find()
                                ->select('indicador.id, indicador.descripcion,indicador.id_oe')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                                ->orderBy(['indicador.descripcion'=>SORT_ASC])
                                ->all();
            
            $actividades=Actividad::find()
                                ->select('actividad.id,actividad.descripcion,actividad.id_ind')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                                ->orderBy(['actividad.descripcion'=>SORT_ASC])
                                ->all();
            
            foreach($indicadores as $ind)
            {
            $sumatotal_actividades=Actividad::find()
                                ->select('sum(actividad.meta) as meta,sum(actividad.ejecutado) as ejecutado')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->where('actividad.id_ind=:id_ind',[':id_ind'=>$ind->id])
                                ->all();
                                
                foreach($sumatotal_actividades as $sumtotal_actividades)                    
            {$total_por_ope = ($sumtotal_actividades->ejecutado * 100) / $sumtotal_actividades->meta;}
            
            
            break;
            }
            
            
        }
        
       }
                
                    
        return $this->render('index',["muestra_dash"=>$muestra_dash,"objetivos"=>$objetivos,"total_por_est"=>$total_por_est,"total_obj"=>$total_obj,"indicadores"=>$indicadores,"actividades"=>$actividades,"total_por_ope"=>$total_por_ope,"total_por_fin"=>$total_por_fin]);
    }
    
    
    public function actionObteneractividad($id)
    {
        $opcion1 = '';
        
        $actividades=Actividad::find()
                                ->where('id_ind=:id_ind',[':id_ind'=>$id])
                                ->orderBy(['descripcion'=>SORT_ASC])
                                ->all();
        
        foreach($actividades as $actividad)
            {
                                                
             $opcion1 .='<div class="col-xs-12 col-sm-7 col-md-12 text-left" ><label>'.$actividad->descripcion.'</label></div>';
                                                  
            }
        
       echo $opcion1; 
    }
    
    public function actionObtener_total_act($id)
    {
        $opcion1 = 0;
        
        
        $sumatotal_actividades=Actividad::find()
                                ->select('sum(actividad.meta) as meta,sum(actividad.ejecutado) as ejecutado')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->where('actividad.id_ind=:id_ind',[':id_ind'=>$id])
                                ->all();
                                
                foreach($sumatotal_actividades as $sumtotal_actividades)                    
            {$opcion1 = ($sumtotal_actividades->ejecutado * 100) / $sumtotal_actividades->meta;}
        
       echo $opcion1; 
    }

}