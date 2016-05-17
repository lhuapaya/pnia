<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observaciones".
 *
 * @property integer $id
 * @property integer $id_aprobaciones
 * @property string $observacion
 *
 * @property Aprobaciones $idAprobaciones
 */
class Observaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_aprobaciones'], 'integer'],
            [['observacion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_aprobaciones' => 'Id Aprobaciones',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAprobaciones()
    {
        return $this->hasOne(Aprobaciones::className(), ['id' => 'id_aprobaciones']);
    }
}
