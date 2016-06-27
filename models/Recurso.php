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
            [['estado','actividad_id', 'clasificador_id'], 'integer'],
            [['ejecutado','precio_unit', 'precio_total', 'cantidad'], 'number'],
            [['detalle'], 'string', 'max' => 3000],
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
            'ejecutado' => 'Ejecutado',
            'estado' => 'Estado',
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
