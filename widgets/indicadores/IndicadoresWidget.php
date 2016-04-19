<?php
namespace app\widgets\indicadores;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Actividad;
use app\models\ObjetivoEspecifico;
use app\models\Proyecto;
use app\models\PlanPresupuestal;
use app\models\Integrante;
use app\models\Equipo;
use app\models\Estudiante;
use app\models\Usuario;
use app\models\Cronograma;
use app\models\Indicador;
class IndicadoresWidget extends Widget
{
    public $objetivo_id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        //$proyecto=Proyecto::findOne($this->proyecto_id);
        //$CountObjetivos=ObjetivoEspecifico::find()->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$this->proyecto_id])->count();
        //$objetivos=ObjetivoEspecifico::find()->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$this->proyecto_id])->all();
        $indicadores=Indicador::find()
                                ->where('id_oe=:objetivo_id',[':objetivo_id'=>$this->objetivo_id])
                                ->all();
        
        return $this->render('indicadores',['indicadores'=>$indicadores
                                            ///'proyecto_id'=>$this->proyecto_id,
                                            //'CountObjetivos'=>$CountObjetivos,
                                            //'objetivos'=>$objetivos
                                            ]);
    }
}