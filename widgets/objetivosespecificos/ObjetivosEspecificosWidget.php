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
    public $id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        //var_dump($this->id);die;
        $objetivosespecificos=ObjetivoEspecifico::find()
                                ->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$this->id])
                                ->all();
        //var_dump($objetivosespecificos);die;
        //if ($actividad->load(\Yii::$app->request->post())) {
            
            //1return \Yii::$app->getResponse()->refresh();
        //}
        
        return $this->render('objetivos_especificos',['objetivosespecificos'=>$objetivosespecificos]);
    }
}