<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PolicialCargo;

/**
 * PolicialCargoSearch represents the model behind the search form about `app\models\PolicialCargo`.
 */
class PolicialCargoSearch extends PolicialCargo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial_cargo', 'idpolicial', 'idcargo'], 'integer'],
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
        $query = PolicialCargo::find();

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
            'idpolicial_cargo' => $this->idpolicial_cargo,
            'idpolicial' => $this->idpolicial,
            'idcargo' => $this->idcargo,
            'inicio' => $this->inicio,
            'fim' => $this->fim,
        ]);

        return $dataProvider;
    }
}
