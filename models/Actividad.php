<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property integer $id
 * @property integer $id_ind
 * @property string $descripcion
 * @property integer $peso
 * @property string $unidad_medida
 * @property string $meta
 * @property integer $programado
 *
 * @property Indicador $idInd
 * @property Cronograma[] $cronogramas
 */
class Actividad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'actividad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ind'], 'required'],
            [['id_ind', 'peso', 'programado'], 'integer'],
            [['descripcion'], 'string', 'max' => 3000],
            [['unidad_medida'], 'string', 'max' => 100],
            [['meta'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ind' => 'Id Ind',
            'descripcion' => 'Descripcion',
            'peso' => 'Peso',
            'unidad_medida' => 'Unidad Medida',
            'meta' => 'Meta',
            'programado' => 'Programado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInd()
    {
        return $this->hasOne(Indicador::className(), ['id' => 'id_ind']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCronogramas()
    {
        return $this->hasMany(Cronograma::className(), ['id_actividad' => 'id']);
    }
}
