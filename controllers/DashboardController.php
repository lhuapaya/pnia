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
use app\models\RecursoProgramado;
use app\models\Aportante;
use app\models\DetalleRendicion;
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
        $total_est = 0;
        $total_por_ope = 0;
        $total_ope = 0;
        $total_ope2 = 0;
        $total_por_fin = 0;
        $total_obj = [];
        $objetivos = new ObjetivoEspecifico();
        $indicadores = new Indicador();
        $actividades = new Actividad();
        $suma_recursop = new RecursoProgramado();
        
        $muestra_dash = 0;
        
      /* if(Yii::$app->user->identity->id_perfil == 2)
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
                
                {$total_obj[$i] = ($sumt_ind->ejecutado/$sumt_ind->meta)*100;}
                $i++;
            }
            
            
            foreach($objetivos as $obj)
            {
                $suma_indicador=Indicador::find()
                                ->select('indicador.id, indicador.meta,indicador.ejecutado,indicador.peso')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->where('indicador.id_oe=:id_oe',[':id_oe'=>$obj->id])
                                ->all();
                                
            foreach($suma_indicador as $ind)
            {
                
                $total_est += ((($ind->ejecutado / $ind->meta)*100)*$ind->peso);
            }
                $total_est = $total_est /100;
                $total_est = $total_est * $obj->peso;
                
                
                $total_por_est += $total_est;
                $total_est = 0;
            
            
            }
            $total_por_est = $total_por_est /100;
            
            
            $indicadores=Indicador::find()
                                ->select('indicador.id, indicador.descripcion,indicador.id_oe')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                                ->orderBy(['indicador.descripcion'=>SORT_ASC])
                                ->all();
            
            $actividades=Actividad::find()
                                ->select('actividad.id,actividad.descripcion,actividad.id_ind,actividad.meta,actividad.ejecutado')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                                ->orderBy(['actividad.descripcion'=>SORT_ASC])
                                ->all();
            
            
            foreach($objetivos as $obj)
            {
                $suma_indicador=Indicador::find()
                                ->select('indicador.id, indicador.meta,indicador.ejecutado,indicador.peso')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->where('indicador.id_oe=:id_oe',[':id_oe'=>$obj->id])
                                ->all();
                                
            foreach($suma_indicador as $ind)
            {
            $sumatotal_actividades=Actividad::find()
                                ->select('actividad.meta ,actividad.ejecutado, actividad.peso')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->where('actividad.id_ind=:id_ind',[':id_ind'=>$ind->id])
                                ->all();
                                
                foreach($sumatotal_actividades as $sumtotal_actividades)                    
            {
                //$total_por_ope = ($sumtotal_actividades->ejecutado * 100) / $sumtotal_actividades->meta;
                $total_ope += ((($sumtotal_actividades->ejecutado / $sumtotal_actividades->meta)*100)*$sumtotal_actividades->peso);
            }
            
            $total_ope = $total_ope/100;
            $total_ope = $total_ope * $ind->peso;
            
            $total_ope2 +=$total_ope;
            
            
            $total_ope = 0;
            //break;
            }
                $total_ope2 = $total_ope2 /100;
                $total_ope2 = $total_ope2 * $obj->peso;
                
                
                $total_por_ope += $total_ope2;
                $total_ope2 = 0;
            
            
            }
            $total_por_ope = $total_por_ope /100;
            
            
            
            
            $suma_recursop = RecursoProgramado::find()
                        ->select('recurso_programado.anio, sum(recurso.precio_unit*recurso_programado.cantidad) as cantidad')
                                ->innerJoin('recurso','recurso.id=recurso_programado.id_recurso')
                                ->innerJoin('aportante','aportante.id=recurso.fuente')
                                ->innerJoin('actividad','actividad.id=recurso.actividad_id')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario and aportante.tipo = 1 ',[':user_propietario'=>Yii::$app->user->identity->id])
                                ->groupBy(['recurso_programado.anio'])
                                ->orderBy(['recurso_programado.anio'=>SORT_ASC])
                                ->all();
                                
                                
            foreach($suma_recursop as $sum_recursop)
            {
                
            }
            
            $aportante = Aportante::find()
                            ->where('tipo = 1 and id_proyecto = :id_proyecto',[":id_proyecto"=>$proyecto->id])
                            ->one();
            
            $rendido = DetalleRendicion::find()
                        ->innerJoin('rendicion','rendicion.id=detalle_rendicion.id_rendicion')
                        ->where('rendicion.estado = 2 and rendicion.id_user = :id_user',[":id_user"=>Yii::$app->user->identity->id])
                        ->sum('detalle_rendicion.total');
            
            $total_por_fin = ($rendido /$aportante->total) * 100;
        }
        
       }*/
                
                    
        return $this->render('index',["muestra_dash"=>$muestra_dash,"objetivos"=>$objetivos,"total_por_est"=>$total_por_est,"total_obj"=>$total_obj,"indicadores"=>$indicadores,"actividades"=>$actividades,"total_por_ope"=>$total_por_ope,"total_por_fin"=>$total_por_fin,"suma_recursop"=>$suma_recursop]);
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