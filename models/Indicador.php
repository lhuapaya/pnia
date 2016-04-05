<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicador".
 *
 * @property integer $id
 * @property integer $id_oe
 * @property string $descripcion
 * @property integer $peso
 * @property string $unidad_medida
 * @property integer $programado
 *
 * @property Actividad[] $actividads
 * @property ObjetivoEspecifico $idOe
 */
class Indicador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'indicador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id'], 'required'],
            [['id', 'id_oe', 'peso', 'programado'], 'integer'],
            [['descripcion'], 'string', 'max' => 500],
            [['unidad_medida'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_oe' => 'Id Oe',
            'descripcion' => 'Descripcion',
            'peso' => 'Peso',
            'unidad_medida' => 'Unidad Medida',
            'programado' => 'Programado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['id_ind' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOe()
    {
        return $this->hasOne(ObjetivoEspecifico::className(), ['id' => 'id_oe']);
    }
}
