<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Posto;

/**
 * PostoSearch represents the model behind the search form about `app\models\Posto`.
 */
class PostoSearch extends Posto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idposto'], 'integer'],
            [['nome_posto'], 'safe'],
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
        $query = Posto::find();

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
            'idposto' => $this->idposto,
        ]);

        $query->andFilterWhere(['like', 'nome_posto', $this->nome_posto]);

        return $dataProvider;
    }
}
