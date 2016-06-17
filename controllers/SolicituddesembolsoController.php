<?php

namespace app\controllers;

use Yii;
use app\models\SolicitudDesembolso;
use app\models\Proyecto;
use app\models\NivelAprobacion;
use app\models\DetalleSolicitud;
use app\models\RecursoProgramado;
use app\models\AprobacionDesembolso;
use app\models\Aprobaciones;
use app\models\SolicitudDesembolsoSearch;
use app\models\DetalleSolicitudSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SolicituddesembolsoController implements the CRUD actions for SolicitudDesembolso model.
 */
class SolicituddesembolsoController extends Controller
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
     * Lists all SolicitudDesembolso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='principal';
        $searchModel = new SolicitudDesembolsoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,1);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SolicitudDesembolso model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout='principal';
        $hoy = getdate();
        $searchModel = new DetalleSolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        
        $model = new SolicitudDesembolso();
        
        if($model->load(Yii::$app->request->post()) )
        {
            //var_dump($model->id_sol);die;
            $nivelApLast = NivelAprobacion::find()
                            ->where('id_actividad = :id_actividad',[':id_actividad'=>83])
                            ->orderBy(['orden'=>SORT_DESC])
                            ->one();
              
            $nivelAp = NivelAprobacion::find()
                            ->where('id_actividad = :id_actividad',[':id_actividad'=>83])
                            ->orderBy(['orden'=>SORT_ASC])
                            ->all();
            
            foreach($nivelAp as $nivelAp2)
            {
                $AprobCount = AprobacionDesembolso::find()
                                ->where('id_solicitud = :id_solicitud and id_nivelaprobacion =:id_nivelaprobacion',[':id_solicitud'=>(int)$model->id_sol,':id_nivelaprobacion'=>$nivelAp2->id])
                                ->count();
                                
                if($AprobCount > 0)
                {
                    /*$Aprobaciones = Aprobaciones::find()
                                ->where('id_proyecto = :id_proyecto and id_nivelaprobacion =:id_nivelaprobacion',[':id_proyecto'=>$proyecto->id,':id_nivelaprobacion'=>$nivelAp2->id])
                                ->one();
                                
                    if($Aprobaciones->estado == 0)
                    {
                        $aprob =Aprobaciones::findOne($Aprobaciones->id);
                        $aprob->id_proyecto = $proyecto->id;
                        $aprob->id_nivelaprobacion = $nivelAp2->id;
                        $aprob->estado = $proyecto->respuesta_aprob;
                        $aprob->update();
                         break; 
                    }*/
                    
                }
                else{
                    //var_dump((int)$proyecto->id);var_dump((int)$nivelAp2->id);var_dump($proyecto->respuesta_aprob);die;
                    $aprob =new AprobacionDesembolso();
                    $aprob->id_solicitud = (int)$model->id_sol;
                    $aprob->id_nivelaprobacion = (int)$nivelAp2->id;
                    $aprob->estado = (int)$model->respuesta_aprob;
                    $aprob->save();
                    break;
                }
            }
                                
           if($model->respuesta_aprob == 0)
                {
                    
                    
                    $sol = SolicitudDesembolso::findOne((int)$model->id_sol);
                    $sol->observacion = $model->observacion;
                    $sol->estado = 3;
                    $sol->fecha_aprobacion = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
                    $sol->id_user_obs = Yii::$app->user->identity->id;
                    $sol->update();
                    
                    DetalleSolicitud::updateAll(['estado' => 3], 'id_solicitud = :id_solicitud',[':id_solicitud'=>(int)$model->id_sol]);
                    /*$dsol = DetalleSolicitud::find()->where('id_solicitud = :id_solicitud',[':id_solicitud'=>(int)$model->id_sol])->all();
                    $dsol->estado = 3;
                    $dsol->update();*/
                    
                }
                
                if($model->respuesta_aprob == 1)
                {
                    if(Yii::$app->user->identity->id_perfil == $nivelApLast->id_perfil)
                    {
                        $sol = SolicitudDesembolso::findOne((int)$model->id_sol);
                        $sol->estado = 1;
                        $sol->fecha_aprobacion = $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
                        $sol->update();
                        
                        
                        DetalleSolicitud::updateAll(['estado' => 1], 'id_solicitud = :id_solicitud',[':id_solicitud'=>(int)$model->id_sol]);
                    
                        $detalle = DetalleSolicitud::find()
                                    ->where('id_solicitud = :id_solicitud',[':id_solicitud'=>(int)$model->id_sol])
                                    ->all();

                        
                        foreach($detalle as $det)
                        {
                            
                        $recursoP = RecursoProgramado::find()
                                ->select('recurso_programado.id, recurso_programado.anio, recurso_programado.mes, recurso_programado.estado')
                                ->innerJoin('recurso','recurso.id=recurso_programado.id_recurso')
                                ->innerJoin('aportante','aportante.id=recurso.fuente')
                                ->innerJoin('actividad','actividad.id=recurso.actividad_id')
                                ->innerJoin('indicador','indicador.id=actividad.id_ind')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.user_propietario=:user_propietario and proyecto.estado = 1 and  aportante.tipo = 1 and recurso_programado.anio = :anio and recurso_programado.mes = :mes',[':user_propietario'=>$sol->id_user,':anio'=>$det->anio,':mes'=>$det->mes])
                                ->all();
                            
                            foreach($recursoP as $rp)
                            {
                                $rpr = RecursoProgramado::findOne($rp->id);
                                $rpr->estado = 1;
                                $rpr->update();
                            }
                            
                        }
                    }
                    
                    
                    
                }
                
              
            
            return $this->redirect('index');
            
                
              
            
        }
        else
        {
            $solicitud = SolicitudDesembolso::findOne((int)$id);
        
            $nivelAp = NivelAprobacion::find()
                            ->where('id_actividad = :id_actividad',[':id_actividad'=>83])
                            ->orderBy(['orden'=>SORT_ASC])
                            ->all();
            $nivel = '';
            foreach($nivelAp as $nivelAp2)
            {
                $AprobCount = AprobacionDesembolso::find()
                                ->where('id_solicitud = :id_solicitud and id_nivelaprobacion =:id_nivelaprobacion',[':id_solicitud'=>(int)$id,':id_nivelaprobacion'=>$nivelAp2->id])
                                ->count();
                                
                if($AprobCount > 0)
                {
                   /* $Aprobaciones = AprobacionDesembolso::find()
                                ->where('id_solicitud = :id_solicitud and id_nivelaprobacion =:id_nivelaprobacion',[':id_solicitud'=>(int)$model->id_sol,':id_nivelaprobacion'=>$nivelAp2->id])
                                ->one();
                                
                    if($Aprobaciones->estado == 3)
                    {
                       $nivel = $nivelAp2->id_perfil;
                         break; 
                    }*/
                    
                }
                else{
                    $nivel = $nivelAp2->id_perfil;
                    break;
                }
            }
            
            $requiere_aprobar = 0;
            if(Yii::$app->user->identity->id_perfil == $nivel)
            {
               $requiere_aprobar = 1; 
            }
        }
        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$id,
            'solicitud'=>$solicitud,
            'requiere_aprobar'=>$requiere_aprobar
        ]);
    
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
    }

    /**
     * Creates a new SolicitudDesembolso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SolicitudDesembolso();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SolicitudDesembolso model.
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
     * Deletes an existing SolicitudDesembolso model.
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
     * Finds the SolicitudDesembolso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SolicitudDesembolso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SolicitudDesembolso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionCierre()
    {
        $this->layout='principal';
        $searchModel = new SolicitudDesembolsoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,2);

        return $this->render('cierre', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
}
