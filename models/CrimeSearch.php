<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Crime;

/**
 * CrimeSearch represents the model behind the search form about `app\models\Crime`.
 */
class CrimeSearch extends Crime
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcrime'], 'integer'],
            [['nome', 'artigo', 'lei'], 'safe'],
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
        $query = Crime::find();

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
            'idcrime' => $this->idcrime,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'artigo', $this->artigo])
            ->andFilterWhere(['like', 'lei', $this->lei]);

        return $dataProvider;
    }
}
