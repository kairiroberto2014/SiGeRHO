<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PolicialDiaria;

/**
 * PolicialDiariaSearch represents the model behind the search form about `app\models\PolicialDiaria`.
 */
class PolicialDiariaSearch extends PolicialDiaria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial_diaria', 'idpolicial', 'iddiaria', 'executada', 'justificada'], 'integer'],
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
        $query = PolicialDiaria::find();

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
            'idpolicial_diaria' => $this->idpolicial_diaria,
            'idpolicial' => $this->idpolicial,
            'iddiaria' => $this->iddiaria,
            'executada' => $this->executada,
            'justificada' => $this->justificada,
        ]);

        return $dataProvider;
    }
}
