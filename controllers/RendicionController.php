<?php

namespace app\controllers;

use Yii;
use app\models\Rendicion;
use app\models\SolicitudDesembolso;
use app\models\RendicionSearch;
use app\models\DetalleRendicion;
use app\models\RecursoProgramado;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RendicionController implements the CRUD actions for Rendicion model.
 */
class RendicionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Rendicion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='principal';
        $searchModel = new RendicionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rendicion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rendicion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rendicion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Rendicion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Rendicion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rendicion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rendicion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rendicion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionDetalle()
    {
        $this->layout='principal';
        
        $model = new DetalleRendicion();
        
        //svar_dump($model->load(Yii::$app->request->post()));
        if ($model->load(Yii::$app->request->post()))
        {
            $countregistros = count(array_filter($model->clasificador_id));
            
            //var_dump($countregistros);die;
            
            $hoy = getdate();
            
            $desembolsos = SolicitudDesembolso::find()
                            ->where('estado = 1 and id_user = :id_user',[':id_user'=>Yii::$app->user->identity->id])
                            ->one();
           // var_dump($desembolsos->id);die;                
                        $rendicion=new Rendicion();
                        $rendicion->id_user= Yii::$app->user->identity->id;
                        $rendicion->fecha= $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
                        $rendicion->id_solicitud = $desembolsos->id;
                        $rendicion->save();
            
                    /*if($model->detalle_ids[$i] != '')
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
                    {*/
                    /*for($i=0;$i<$countregistros;$i++)
                    {
                   
                        $detRendicion=new DetalleRendicion;
                        $detRendicion->id_proyecto=$proyecto->id;
                        $detRendicion->colaborador=$proyecto->aportante_colaborador[$i];
                        $detRendicion->regimen=$proyecto->aportante_regimen[$i];
                        $detRendicion->tipo_inst=$proyecto->aportante_tipo_inst[$i];
                        $detRendicion->tipo=3;
                        $detRendicion->save();
                    }*/
                    //}
                    
            return $this->redirect('index');
            
        }
        else
        {
          $clasificadores = RecursoProgramado::find()
                        ->select('recurso.clasificador_id, maestros.descripcion')
                                ->innerJoin('recurso','recurso.id=recurso_programado.id_recurso')
                                ->innerJoin('aportante','aportante.id=recurso.fuente')
                                ->innerJoin('maestros','maestros.id=recurso.clasificador_id')
                                ->innerJoin('actividad','actividad.id=recurso.actividad_id')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario and aportante.tipo = 1 and recurso_programado.estado = 1 and recurso_programado.cantidad > 0  ',[':user_propietario'=>Yii::$app->user->identity->id])
                                ->groupBy(['recurso.clasificador_id'])
                                ->all();
                                
                               // var_dump($clasificadores);die;
        }
        
        return $this->render('detalle',['clasificadores'=>$clasificadores]);
    }
    
    
    public function actionObtener_descripcion_recurso($clasificador,$user)
    {
        $option = '<option value="0">--Seleccione--</option>';
       $descripcion = RecursoProgramado::find()
                        ->select('recurso.id, recurso.detalle')
                                ->innerJoin('recurso','recurso.id=recurso_programado.id_recurso')
                                ->innerJoin('aportante','aportante.id=recurso.fuente')
                                ->innerJoin('maestros','maestros.id=recurso.clasificador_id')
                                ->innerJoin('actividad','actividad.id=recurso.actividad_id')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario and aportante.tipo = 1 and recurso_programado.estado = 1 and recurso_programado.cantidad > 0  and recurso.clasificador_id = :clasificador_id',[':user_propietario'=>$user,':clasificador_id'=>$clasificador])
                                ->groupBy(['recurso.id'])
                                ->all();
                            
        foreach($descripcion as $des)
        {
           $option .= '<option value="'.$des->id.'" >'.$des->detalle.'</option>';
        }
        
        echo $option;
    }
    
    public function actionObtener_anio_repro($id_des,$clasificador,$user)
    {
        $option = '<option value="0">--Seleccione--</option>';
       $anio = RecursoProgramado::find()
                        ->select('recurso_programado.anio')
                                ->innerJoin('recurso','recurso.id=recurso_programado.id_recurso')
                                ->innerJoin('aportante','aportante.id=recurso.fuente')
                                ->innerJoin('maestros','maestros.id=recurso.clasificador_id')
                                ->innerJoin('actividad','actividad.id=recurso.actividad_id')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario and aportante.tipo = 1 and recurso_programado.estado = 1 and recurso_programado.cantidad > 0  and recurso.clasificador_id = :clasificador_id and recurso.id = :re_id',[':user_propietario'=>$user,':clasificador_id'=>$clasificador,':re_id'=>$id_des])
                                ->groupBy(['recurso_programado.anio'])
                                ->all();
                            
        foreach($anio as $anio2)
        {
           $option .= '<option value="'.$anio2->anio.'" >'.$anio2->anio.'</option>';
        }
        
        echo $option;
    }
    
    
    public function actionObtener_mes_repro($anio,$id_des,$clasificador,$user)
    {
        $option = '<option value="0">--Seleccione--</option>';
       $mes = RecursoProgramado::find()
                        ->select('recurso_programado.mes')
                                ->innerJoin('recurso','recurso.id=recurso_programado.id_recurso')
                                ->innerJoin('aportante','aportante.id=recurso.fuente')
                                ->innerJoin('maestros','maestros.id=recurso.clasificador_id')
                                ->innerJoin('actividad','actividad.id=recurso.actividad_id')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario and aportante.tipo = 1 and recurso_programado.estado = 1 and recurso_programado.cantidad > 0  and recurso.clasificador_id = :clasificador_id and recurso.id = :re_id and recurso_programado.anio = :anio',[':user_propietario'=>$user,':clasificador_id'=>$clasificador,':re_id'=>$id_des,':anio'=>$anio])
                                ->groupBy(['recurso_programado.mes'])
                                ->all();
                            
        foreach($mes as $mes2)
        {
            switch($mes2->mes)
                    {
                        case 1: $des_mes = "Enero"; break;
                        case 2: $des_mes = "Febrero"; break;
                        case 3: $des_mes = "Marzo"; break;
                        case 4: $des_mes = "Abril"; break;
                        case 5: $des_mes = "Mayo"; break;
                        case 6: $des_mes = "Junio"; break;
                        case 7: $des_mes = "Julio"; break;
                        case 8: $des_mes = "Agosto"; break;
                        case 9: $des_mes = "Setiembre"; break;
                        case 10: $des_mes = "Octubre"; break;
                        case 11: $des_mes = "Noviembre"; break;
                        case 12: $des_mes = "Diciembre"; break;
                    }
                    
           $option .= '<option value="'.$mes2->mes.'" >'.$des_mes.'</option>';
        }
        
        echo $option;
    }
    
    public function actionObtener_precio_repro($mes,$anio,$id_des,$clasificador,$user)
    {

       $anio = RecursoProgramado::find()
                        ->select('recurso_programado.precio_unit, (recurso_programado.cantidad - recurso_programado.cant_rendida) as cantidad ')
                                ->innerJoin('recurso','recurso.id=recurso_programado.id_recurso')
                                ->innerJoin('aportante','aportante.id=recurso.fuente')
                                ->innerJoin('maestros','maestros.id=recurso.clasificador_id')
                                ->innerJoin('actividad','actividad.id=recurso.actividad_id')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario and aportante.tipo = 1 and recurso_programado.estado = 1 and recurso_programado.cantidad > 0  and recurso.clasificador_id = :clasificador_id and recurso.id = :re_id and recurso_programado.anio = :anio and recurso_programado.mes = :mes',[':user_propietario'=>$user,':clasificador_id'=>$clasificador,':re_id'=>$id_des,':anio'=>$anio,':mes'=>$mes])
                                ->one();
                            
        
        return json_encode(array('precio_unit'=>$anio->precio_unit,'cantidad'=>$anio->cantidad));
        
    }
}
