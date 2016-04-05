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
    public $proyecto_id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $proyecto=Proyecto::findOne($this->proyecto_id);
        $CountObjetivos=ObjetivoEspecifico::find()->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$this->proyecto_id])->count();
        $objetivos=ObjetivoEspecifico::find()->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$this->proyecto_id])->all();
        $indicadores=Indicador::find()
                                ->select('indicador.id,indicador.descripcion,indicador.id_oe')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=indicador.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$this->proyecto_id])
                                ->all();
        
        return $this->render('indicadores',['indicadores'=>$indicadores,
                                            'proyecto_id'=>$this->proyecto_id,
                                            'CountObjetivos'=>$CountObjetivos,
                                            'objetivos'=>$objetivos]);
    }
}