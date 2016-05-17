<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proyecto;

/**
 * ModificarSearch represents the model behind the search form about `app\models\Proyecto`.
 */
class ModificarSearch extends Proyecto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vigencia', 'id_direccion_linea', 'id_unidad_ejecutora', 'id_dependencia_inia', 'id_tipo_proyecto', 'id_programa', 'id_cultivo', 'id_especie', 'id_areatematica', 'user_propietario', 'tipo_registro', 'situacion', 'estado'], 'integer'],
            [['titulo','date_create','ubigeo', 'desc_tipo_proy', 'resumen_ejecutivo', 'relevancia', 'objetivo_general', 'plan_trabajo', 'resultados_esperados', 'referencias_bibliograficas', 'problematica', 'ind_prob', 'med_prob', 'sup_prob', 'proposito', 'ind_prop', 'med_prop', 'sup_prop'], 'safe'],
            [['presupuesto'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if(\Yii::$app->user->can('investigador'))
        {
        $query = Proyecto::find()
                        ->where('tipo_registro in (1,2) and user_propietario =:user_propietario',[':user_propietario'=>Yii::$app->user->identity->id]);
        }
        else
        {
          $query = Proyecto::find()
                        ->where('tipo_registro in (1,2) and situacion in (0,1) ');  
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'vigencia' => $this->vigencia,
            'id_direccion_linea' => $this->id_direccion_linea,
            'id_unidad_ejecutora' => $this->id_unidad_ejecutora,
            'id_dependencia_inia' => $this->id_dependencia_inia,
            'date_create' => $this->date_create,
            'id_tipo_proyecto' => $this->id_tipo_proyecto,
            'id_programa' => $this->id_programa,
            'id_cultivo' => $this->id_cultivo,
            'id_especie' => $this->id_especie,
            'id_areatematica' => $this->id_areatematica,
            'presupuesto' => $this->presupuesto,
            'user_propietario' => $this->user_propietario,
            'tipo_registro' => $this->tipo_registro,
            'situacion' => $this->situacion,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'ubigeo', $this->ubigeo])
            ->andFilterWhere(['like', 'desc_tipo_proy', $this->desc_tipo_proy])
            ->andFilterWhere(['like', 'resumen_ejecutivo', $this->resumen_ejecutivo])
            ->andFilterWhere(['like', 'relevancia', $this->relevancia])
            ->andFilterWhere(['like', 'objetivo_general', $this->objetivo_general])
            ->andFilterWhere(['like', 'plan_trabajo', $this->plan_trabajo])
            ->andFilterWhere(['like', 'resultados_esperados', $this->resultados_esperados])
            ->andFilterWhere(['like', 'referencias_bibliograficas', $this->referencias_bibliograficas])
            ->andFilterWhere(['like', 'problematica', $this->problematica])
            ->andFilterWhere(['like', 'ind_prob', $this->ind_prob])
            ->andFilterWhere(['like', 'med_prob', $this->med_prob])
            ->andFilterWhere(['like', 'sup_prob', $this->sup_prob])
            ->andFilterWhere(['like', 'proposito', $this->proposito])
            ->andFilterWhere(['like', 'ind_prop', $this->ind_prop])
            ->andFilterWhere(['like', 'med_prop', $this->med_prop])
            ->andFilterWhere(['like', 'sup_prop', $this->sup_prop])
            ->andFilterWhere(['like', 'date_create', $this->date_create]);

        return $dataProvider;
    }
}
