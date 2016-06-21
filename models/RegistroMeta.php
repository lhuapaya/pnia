<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_meta".
 *
 * @property integer $id
 * @property integer $tipo_meta
 * @property integer $id_tipo
 * @property integer $cantidad
 * @property string $fecha
 * @property integer $id_user
 * @property integer $id_user_obs
 * @property string $observacion
 * @property integer $estado
 */
class RegistroMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registro_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo_meta', 'id_tipo', 'cantidad', 'id_user', 'id_user_obs', 'estado'], 'integer'],
            [['fecha'], 'string', 'max' => 20],
            [['observacion'], 'string', 'max' => 7000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_meta' => 'Tipo Meta',
            'id_tipo' => 'Id Tipo',
            'cantidad' => 'Cantidad',
            'fecha' => 'Fecha',
            'id_user' => 'Id User',
            'id_user_obs' => 'Id User Obs',
            'observacion' => 'Observacion',
            'estado' => 'Estado',
        ];
    }
}
