<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PolicialCurso;

/**
 * PolicialCursoSearch represents the model behind the search form about `app\models\PolicialCurso`.
 */
class PolicialCursoSearch extends PolicialCurso
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial_curso', 'idpolicial', 'idcurso', 'horas'], 'integer'],
            [['instituicao', 'inicio', 'fim'], 'safe'],
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
        $query = PolicialCurso::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idpolicial_curso' => $this->idpolicial_curso,
            'idpolicial' => $this->idpolicial,
            'idcurso' => $this->idcurso,
            'inicio' => $this->inicio,
            'fim' => $this->fim,
            'horas' => $this->horas,
        ]);

        $query->andFilterWhere(['like', 'instituicao', $this->instituicao]);

        return $dataProvider;
    }
}
