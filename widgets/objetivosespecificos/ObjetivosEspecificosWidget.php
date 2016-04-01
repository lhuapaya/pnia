<?php
namespace app\widgets\objetivosespecificos;


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
class ObjetivosEspecificosWidget extends Widget
{
    public $proyecto_id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        //var_dump($this->id);die;
        $objetivosespecificos=ObjetivoEspecifico::find()
                                ->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$this->proyecto_id])
                                ->all();
        //var_dump($objetivosespecificos);die;
        //if ($objetivosespecificos->load(\Yii::$app->request->post())) {// este post igual al create
            
            
            
           // return \Yii::$app->getResponse()->refresh();
        //}
        
        return $this->render('objetivos_especificos',['objetivosespecificos'=>$objetivosespecificos,'proyecto_id'=>$this->proyecto_id]);
    }
}