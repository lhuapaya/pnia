<?php
namespace app\widgets\observacion;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Actividad;


class ObservacionWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        
    
        
        return $this->render('observacion',[//'actividades'=>$actividades,
                                            //'act'=>$this->act
                                            //'indicadores'=>$indicadores
                                            ]);
    }
}