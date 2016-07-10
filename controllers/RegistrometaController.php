<?php

namespace app\controllers;

use Yii;
use app\models\RegistroMeta;
use app\models\Indicador;
use app\models\Actividad;
use app\models\RegistroMetaDetalle;
use app\models\Proyecto;
use app\models\RegistroMetaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegistrometaController implements the CRUD actions for RegistroMeta model.
 */
class RegistrometaController extends Controller
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
     * Lists all RegistroMeta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='principal';
        $searchModel = new RegistroMetaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegistroMeta model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $this->layout='principal';
         
         
         $registroMeta = RegistroMeta::findOne($id);
         $registroMetaDet = RegistroMetaDetalle::find()->where('id_registrometa = :id_registrometa',[':id_registrometa'=>$id])->all();
         
         
        return $this->render('view', [
            'registroMeta' => $registroMeta,'registroMetaDet'=>$registroMetaDet
        ]);
    }
    
    public function actionAccion()
    {
         $this->layout='principal';
         
         $model = new RegistroMeta();
         
        if ($model->load(Yii::$app->request->post()))
        {
            return $this->redirect(['create', 'id_tipo' => $model->id_tipo]);
        }
        else{
        return $this->render('accion', []);
        }
    }

    /**
     * Creates a new RegistroMeta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_tipo)
    {
        $this->layout='principal';
        
        $model = new RegistroMeta();

        if ($model->load(Yii::$app->request->post())) {
            
            $countEjecutado=count(array_filter($model->id_indact));
            $hoy = getdate();
            
                        $RegistroMeta =new RegistroMeta;
                        $RegistroMeta->id_tipo=$model->tipo;
                        $RegistroMeta->fecha=$hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
                        $RegistroMeta->id_user=Yii::$app->user->identity->id;
                        $RegistroMeta->save();
            
            for($i=0;$i<$countEjecutado;$i++)

                {
                    /*if(isset($proyecto->zona_ids[$i]))
                    {
                        $zonaAccion=ZonaAccion::findOne($proyecto->zona_ids[$i]);
                        $zonaAccion->id_distrito=$proyecto->zona_distrito[$i];
                        $zonaAccion->update(); 
                    }
                    else
                    {*/
                        
                        $RegistroMetaDet =new RegistroMetaDetalle;
                        $RegistroMetaDet->id_registrometa = $RegistroMeta->id;
                        $RegistroMetaDet->des_indact=$model->des_indact[$i];
                        $RegistroMetaDet->id_indact=$model->id_indact[$i];
                        $RegistroMetaDet->cantidad=$model->cantidad[$i];
                        $RegistroMetaDet->save();
                        
                        if($model->tipo == 1)
                        {
                            $indicador = Indicador::findOne($model->id_indact[$i]);
                            $indicador->ejecutado = ($indicador->ejecutado + $model->cantidad[$i]);
                            $indicador->update(); 
                        }
                        
                        if($model->tipo == 2)
                        {
                            $actividad = Actividad::findOne($model->id_indact[$i]);
                            $actividad->ejecutado = ($actividad->ejecutado + $model->cantidad[$i]);
                            $actividad->update();   
                        }
                        

                   // }
                }
            
            //return $this->refresh();
            return $this->redirect('index');
        } else {
            
              $objetivos = Proyecto::find()
                        ->select('objetivo_especifico.id, objetivo_especifico.descripcion')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id_proyecto = proyecto.id')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                                ->orderBy(['objetivo_especifico.descripcion'=>SORT_ASC])
                                ->all();   
                
              $indicadores = Proyecto::find()
                        ->select('indicador.id, indicador.descripcion, indicador.id_oe, indicador.meta, indicador.ejecutado')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id_proyecto = proyecto.id')
                                ->innerJoin('indicador','indicador.id_oe = objetivo_especifico.id')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                                ->orderBy(['indicador.descripcion'=>SORT_ASC])
                                ->all();
                $actividades = null;
            
            if($id_tipo == 2)
            {
              $actividades = Proyecto::find()
                        ->select('actividad.id, actividad.descripcion, actividad.id_ind, actividad.meta, actividad.ejecutado')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id_proyecto = proyecto.id')
                                ->innerJoin('indicador','indicador.id_oe = objetivo_especifico.id')
                                ->innerJoin('actividad','actividad.id_ind = indicador.id')
                                ->where('proyecto.estado = 1 and proyecto.user_propietario=:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id])
                                ->orderBy(['indicador.descripcion'=>SORT_ASC])
                                ->all();  
            }
            
            return $this->render('create', [
                'indicadores' => $indicadores, 'objetivos' =>$objetivos, 'id_tipo' => $id_tipo, 'actividades' => $actividades
            ]);
        }
    }

    /**
     * Updates an existing RegistroMeta model.
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
     * Deletes an existing RegistroMeta model.
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
     * Finds the RegistroMeta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegistroMeta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegistroMeta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
