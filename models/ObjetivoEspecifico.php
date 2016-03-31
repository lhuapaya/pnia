<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objetivo_especifico".
 *
 * @property integer $id
 * @property integer $id_proyecto
 * @property string $descripcion
 * @property string $indicadores
 * @property string $medios
 * @property string $supuestos
 *
 * @property Actividad[] $actividads
 * @property Proyecto $idProyecto
 */
class ObjetivoEspecifico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objetivo_especifico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_proyecto'], 'required'],
            [['id_proyecto'], 'integer'],
            [['descripcion'], 'string', 'max' => 2000],
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
            'id_proyecto' => 'Id Proyecto',
            'descripcion' => 'Descripcion',
            'indicadores' => 'Indicadores',
            'medios' => 'Medios',
            'supuestos' => 'Supuestos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['id_oe' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProyecto()
    {
        return $this->hasOne(Proyecto::className(), ['id' => 'id_proyecto']);
    }
}
