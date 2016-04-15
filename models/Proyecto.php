<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyecto".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $direccion_linea
 * @property string $estacion_exp
 * @property string $sub_estacion_exp
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
 * @property integer $user_propietario
 * @property integer $estado
 *
 * @property AccionTransversal $accionTransversal
 * @property AlianzaEstrategica[] $alianzaEstrategicas
 * @property Colaborador $colaborador
 * @property CultivoCrianza $cultivoCrianza
 * @property LugarInvestigacion[] $lugarInvestigacions
 * @property ObjetivoEspecifico[] $objetivoEspecificos
 * @property Usuarios $userPropietario
 * @property Recursos[] $recursos
 * @property Responsable $responsable
 */
class Proyecto extends \yii\db\ActiveRecord
{
            public $nombres;
            public $apellidos;
            public $telefono;
            public $celular;
            public $correo;
            /*objetivos*/
            public $objetivos_ids;
            public $objetivos_descripciones;
            /*indicadores*/
            public $indicadores_ids;
            public $indicadores_oe_ids;
            public $indicadores_descripciones;
            /*actividades*/
            public $actividades_ids;
            public $actividades_ind_ids;
            public $actividades_descripciones;
            /*cronogrmas*/
            public $cronogramas_ids;
            public $cronogramas_actividad_ids;
            public $cronogramas_meses;
            

            /*alianzas*/
            public $alianzas_ids;
            public $alianzas_instituciones;
            public $alianzas_descripciones;
            public $alianzas_nombres;
            public $alianzas_apellidos;
            public $alianzas_correos;
            public $alianzas_telefonos;
            
            
            /*colaborador*/
            public $colaboradores_ids;
            public $nombresc;
            public $apellidosc;
            public $funcionesc;
            
            public $ids;
            public $descripciones;
            public $descripcioncc;
            public $tipocc;
            public $idcc;
            
            public $otrosat;
            public $idat;
            
            public $zona_ids;
            public $zona_distrito;
            public $zona_departamento;
    
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
            [['id_direccion_linea','id_unidad_ejecutora','id_dependencia_inia','id_tipo_proyecto', 'user_propietario', 'estado','id'], 'integer'],
            [['presupuesto'], 'number'],
            [['nombres','apellidos','telefono','celular','correo','descripciones','ids','objetivos_ids',
              'objetivos_descripciones','actividades_ids','actividades_ind_ids','actividades_descripciones',
              'indicadores_ids','indicadores_oe_ids','indicadores_descripciones',
              'cronogramas_ids','cronogramas_meses','cronogramas_actividad_ids','descripcioncc','tipocc','idcc','otrosat','idat',
              'alianzas_instituciones','alianzas_descripciones','alianzas_nombres','alianzas_apellidos','alianzas_correos','alianzas_telefonos',
              'alianzas_ids','colaboradores_ids','nombresc','apellidosc','funcionesc','zona_ids','zona_distrito','zona_departamento'], 'safe'],

            //[['titulo', 'direccion_linea', 'estacion_exp', 'sub_estacion_exp'], 'required'],
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
            'id_direccion_linea' => 'Direccion Linea',
            'id_unidad_ejecutora' => 'Unidad Ejecutora',
            'id_dependencia_inia' => 'Dependencia INIA',
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
            'user_propietario' => 'User Propietario',
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
    public function getCultivoCrianza()
    {
        return $this->hasOne(CultivoCrianza::className(), ['id_proyecto' => 'id']);
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
    public function getUserPropietario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'user_propietario']);
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
