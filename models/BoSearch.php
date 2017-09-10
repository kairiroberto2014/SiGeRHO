<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bo;

/**
 * BoSearch represents the model behind the search form about `app\models\Bo`.
 */
class BoSearch extends Bo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idbo'], 'integer'],
            [['data', 'hora', 'local', 'descricao', 'viatura', 'pb', 'hora_trans', 'bairro', 'material'], 'safe'],
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
        $query = Bo::find();

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
            'idbo' => $this->idbo,
            'data' => $this->data,
            'hora' => $this->hora,
            'hora_trans' => $this->hora_trans,
        ]);

        $query->andFilterWhere(['like', 'local', $this->local])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'viatura', $this->viatura])
            ->andFilterWhere(['like', 'pb', $this->pb])
            ->andFilterWhere(['like', 'bairro', $this->bairro])
            ->andFilterWhere(['like', 'material', $this->material]);

        return $dataProvider;
    }
}
