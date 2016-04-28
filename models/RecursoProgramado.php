<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recurso_programado".
 *
 * @property integer $id
 * @property integer $id_recurso
 * @property integer $anio
 * @property integer $mes
 * @property integer $cantidad
 *
 * @property Recurso $idRecurso
 */
class RecursoProgramado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recurso_programado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_recurso', 'anio', 'mes', 'cantidad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_recurso' => 'Id Recurso',
            'anio' => 'Anio',
            'mes' => 'Mes',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRecurso()
    {
        return $this->hasOne(Recurso::className(), ['id' => 'id_recurso']);
    }
}
