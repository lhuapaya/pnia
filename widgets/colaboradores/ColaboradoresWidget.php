<?php
namespace app\widgets\colaboradores;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Colaborador;
use app\models\Usuario;

class ColaboradoresWidget extends Widget
{
    public $id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        //var_dump($this->id);die;
        $colaborador=Colaborador::find()
                                ->where('id_proyecto=:id_proyecto',[':id_proyecto'=>$this->id])
                                ->all();
        //var_dump($objetivosespecificos);die;
        //if ($actividad->load(\Yii::$app->request->post())) {
            
            //1return \Yii::$app->getResponse()->refresh();
        //}
        
        return $this->render('colaboradores',['colaborador'=>$colaborador,'proyecto_id'=>$this->id]
                             );
    }
}