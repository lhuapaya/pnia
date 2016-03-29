<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyecto".
 *
 * @property integer $id
 * @property string $titulo
 * @property integer $id_tipo_proyecto
 * @property string $desc_tipo_proy
 * @property string $resumen_ejecutivo
 * @property string $relevancia
 * @property string $objetivo_general
 * @property string $plan_trabajo
 * @property string $resultados_esperados
 * @property string $presupuesto
 * @property string $referencias_bibliograficas
 * @property string $problematica
 * @property string $ind_prob
 * @property string $med_prob
 * @property string $sup_prob
 * @property string $proposito
 * @property string $ind_prop
 * @property string $med_prop
 * @property string $sup_prop
 * @property integer $estado
 *
 * @property AccionTransversal $accionTransversal
 * @property Actividad[] $actividads
 * @property AlianzaEstrategica[] $alianzaEstrategicas
 * @property Colaborador $colaborador
 * @property Cronograma[] $cronogramas
 * @property CultivoCrianza $cultivoCrianza
 * @property Dependencia $dependencia
 * @property LugarInvestigacion[] $lugarInvestigacions
 * @property ObjetivoEspecifico[] $objetivoEspecificos
 * @property Recursos[] $recursos
 * @property Responsable $responsable
 */
class Proyecto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyecto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_proyecto', 'estado'], 'integer'],
            [['presupuesto'], 'number'],
            [['titulo', 'ind_prob', 'med_prob', 'sup_prob', 'ind_prop', 'med_prop', 'sup_prop'], 'string', 'max' => 500],
            [['desc_tipo_proy'], 'string', 'max' => 200],
            [['resumen_ejecutivo', 'relevancia'], 'string', 'max' => 9000],
            [['objetivo_general'], 'string', 'max' => 4000],
            [['plan_trabajo', 'resultados_esperados'], 'string', 'max' => 8000],
            [['referencias_bibliograficas'], 'string', 'max' => 10000],
            [['problematica', 'proposito'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'id_tipo_proyecto' => 'Id Tipo Proyecto',
            'desc_tipo_proy' => 'Desc Tipo Proy',
            'resumen_ejecutivo' => 'Resumen Ejecutivo',
            'relevancia' => 'Relevancia',
            'objetivo_general' => 'Objetivo General',
            'plan_trabajo' => 'Plan Trabajo',
            'resultados_esperados' => 'Resultados Esperados',
            'presupuesto' => 'Presupuesto',
            'referencias_bibliograficas' => 'Referencias Bibliograficas',
            'problematica' => 'Problematica',
            'ind_prob' => 'Ind Prob',
            'med_prob' => 'Med Prob',
            'sup_prob' => 'Sup Prob',
            'proposito' => 'Proposito',
            'ind_prop' => 'Ind Prop',
            'med_prop' => 'Med Prop',
            'sup_prop' => 'Sup Prop',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccionTransversal()
    {
        return $this->hasOne(AccionTransversal::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlianzaEstrategicas()
    {
        return $this->hasMany(AlianzaEstrategica::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColaborador()
    {
        return $this->hasOne(Colaborador::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCronogramas()
    {
        return $this->hasMany(Cronograma::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCultivoCrianza()
    {
        return $this->hasOne(CultivoCrianza::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencia()
    {
        return $this->hasOne(Dependencia::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLugarInvestigacions()
    {
        return $this->hasMany(LugarInvestigacion::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjetivoEspecificos()
    {
        return $this->hasMany(ObjetivoEspecifico::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecursos()
    {
        return $this->hasMany(Recursos::className(), ['id_proyecto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsable()
    {
        return $this->hasOne(Responsable::className(), ['id_proyecto' => 'id']);
    }
}
