<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property integer $id
 * @property integer $id_oe
 * @property string $descripcion
 * @property string $indicadores
 * @property string $medios
 * @property string $supuestos
 *
 * @property ObjetivoEspecifico $idOe
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
            //[['id_oe'], 'required'],
            [['id_oe'], 'integer'],
            [['descripcion'], 'string', 'max' => 3000],
            [['indicadores', 'medios', 'supuestos'], 'string', 'max' => 500]
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
            'indicadores' => 'Indicadores',
            'medios' => 'Medios',
            'supuestos' => 'Supuestos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOe()
    {
        return $this->hasOne(ObjetivoEspecifico::className(), ['id' => 'id_oe']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCronogramas()
    {
        return $this->hasMany(Cronograma::className(), ['id_actividad' => 'id']);
    }
}
