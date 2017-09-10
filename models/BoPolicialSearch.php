<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BoPolicial;

/**
 * BoPolicialSearch represents the model behind the search form about `app\models\BoPolicial`.
 */
class BoPolicialSearch extends BoPolicial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idbo_policial', 'idbo', 'idpolicial'], 'integer'],
            [['cmt'], 'boolean'],
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
        $query = BoPolicial::find();

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
            'idbo_policial' => $this->idbo_policial,
            'idbo' => $this->idbo,
            'idpolicial' => $this->idpolicial,
            'cmt' => $this->cmt,
        ]);

        return $dataProvider;
    }
}
