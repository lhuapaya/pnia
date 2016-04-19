<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recurso".
 *
 * @property integer $id
 * @property integer $actividad_id
 * @property integer $clasificador_id
 * @property string $detalle
 * @property string $unidad_medida
 * @property integer $cantidad
 * @property string $precio_unit
 * @property string $precio_total
 *
 * @property Actividad $actividad
 */
class Recurso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recurso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['actividad_id', 'clasificador_id', 'cantidad'], 'integer'],
            [['precio_unit', 'precio_total'], 'number'],
            [['detalle'], 'string', 'max' => 500],
            [['unidad_medida'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actividad_id' => 'Actividad ID',
            'clasificador_id' => 'Clasificador ID',
            'detalle' => 'Detalle',
            'unidad_medida' => 'Unidad Medida',
            'cantidad' => 'Cantidad',
            'precio_unit' => 'Precio Unit',
            'precio_total' => 'Precio Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividad()
    {
        return $this->hasOne(Actividad::className(), ['id' => 'actividad_id']);
    }
}
