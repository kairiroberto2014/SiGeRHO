<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PolicialUnidade;

/**
 * PolicialUnidadeSearch represents the model behind the search form about `app\models\PolicialUnidade`.
 */
class PolicialUnidadeSearch extends PolicialUnidade
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial_unidade', 'idpolicial', 'idunidade'], 'integer'],
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
        $query = PolicialUnidade::find();

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
            'idpolicial_unidade' => $this->idpolicial_unidade,
            'idpolicial' => $this->idpolicial,
            'idunidade' => $this->idunidade,
            'inicio' => $this->inicio,
            'fim' => $this->fim,
        ]);

        return $dataProvider;
    }
}
