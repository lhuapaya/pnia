<?php
namespace app\widgets\cronogramas;


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
class CronogramasWidget extends Widget
{
    public $proyecto_id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $proyecto=Proyecto::findOne($this->proyecto_id);
        $CountActividades=$actividades=Actividad::find()
                                ->select('actividad.id,actividad.descripcion,actividad.id_oe')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$this->proyecto_id])
                                ->count();
        $objetivos=ObjetivoEspecifico::find()->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$this->proyecto_id])->all();
        $actividades=Actividad::find()
                                ->select('actividad.id,actividad.descripcion,actividad.id_oe')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$this->proyecto_id])
                                ->all();
        
        $cronogramas=Cronograma::find()
                                ->select('cronograma.mes,cronograma.id_actividad')
                                ->innerJoin('actividad','actividad.id=cronograma.id_actividad')
                                ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.id_oe')
                                ->innerJoin('proyecto','proyecto.id=objetivo_especifico.id_proyecto')
                                ->where('proyecto.id=:proyecto_id',[':proyecto_id'=>$this->proyecto_id])
                                ->all();
        
        return $this->render('cronogramas',['cronogramas'=>$cronogramas,'actividades'=>$actividades,
                                            'proyecto_id'=>$this->proyecto_id,'CountActividades'=>$CountActividades]);
    }
}