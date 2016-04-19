<?php
namespace app\widgets\recursos;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Usuario;
use app\models\Recurso;
use app\models\Maestros;

class RecursosWidget extends Widget
{
    public $actividad_id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        
        
        $recursos=Recurso::find()
                                ->where('actividad_id=:actividad_id',[':actividad_id'=>$this->actividad_id])
                                ->all();
                                
        $clasificador = Maestros::find()
                                ->where('id_padre = 32 and estado = 1')
                                ->orderBy('orden')
                                ->all();
        //var_dump($objetivosespecificos);die;
        //if ($actividad->load(\Yii::$app->request->post())) {
            
            //1return \Yii::$app->getResponse()->refresh();
        //}
        
        return $this->render('recursos',['recursos'=>$recursos,'clasificador'=>$clasificador]
                             );
    }
}