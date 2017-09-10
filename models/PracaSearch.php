<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Praca;

/**
 * PracaSearch represents the model behind the search form about `app\models\Praca`.
 */
class PracaSearch extends Praca
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpraca', 'idpolicial', 'idgraduacao'], 'integer'],
            [['numero_praca'], 'safe'],
            [['inicio', 'fim'], 'safe'],
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
        $query = Praca::find();

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
            'idpraca' => $this->idpraca,
            'idpolicial' => $this->idpolicial,
            'idgraduacao' => $this->idgraduacao,
            'inicio' => $this->inicio,
            'fim' => $this->fim,
        ]);

        $query->andFilterWhere(['like', 'numero_praca', $this->numero_praca]);

        return $dataProvider;
    }
}
