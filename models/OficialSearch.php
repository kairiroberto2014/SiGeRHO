<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Oficial;

/**
 * OficialSearch represents the model behind the search form about `app\models\Oficial`.
 */
class OficialSearch extends Oficial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idoficial', 'idpolicial', 'idposto'], 'integer'],
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
        $query = Oficial::find();

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
            'idoficial' => $this->idoficial,
            'idpolicial' => $this->idpolicial,
            'idposto' => $this->idposto,
            'inicio' => $this->inicio,
            'fim' => $this->fim,
        ]);

        return $dataProvider;
    }
}
