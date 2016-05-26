<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_rendicion".
 *
 * @property integer $id
 * @property integer $id_rendicion
 * @property integer $id_clasificador
 * @property string $descripcion
 * @property integer $cantidad
 * @property string $precio_unit
 * @property string $total
 * @property string $ruc
 * @property string $razon_social
 *
 * @property Rendicion $idRendicion
 */
class DetalleRendicion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_rendicion';
    }

    /**
     * @inheritdoc
     */
    public $clasificador_id;
    public function rules()
    {
        return [
            [['id', 'id_rendicion', 'id_clasificador', 'cantidad'], 'integer'],
            [['precio_unit', 'total'], 'number'],
            [['clasificador_id'],'safe'],
            [['descripcion', 'razon_social'], 'string', 'max' => 200],
            [['ruc'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_rendicion' => 'Id Rendicion',
            'id_clasificador' => 'Id Clasificador',
            'descripcion' => 'Descripcion',
            'cantidad' => 'Cantidad',
            'precio_unit' => 'Precio Unit',
            'total' => 'Total',
            'ruc' => 'Ruc',
            'razon_social' => 'Razon Social',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRendicion()
    {
        return $this->hasOne(Rendicion::className(), ['id' => 'id_rendicion']);
    }
}
