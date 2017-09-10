<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BoPessoa;

/**
 * BoPessoaSearch represents the model behind the search form about `app\models\BoPessoa`.
 */
class BoPessoaSearch extends BoPessoa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idbo_pessoa', 'idbo', 'idpessoa', 'idpessoa_tipo'], 'integer'],
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
        $query = BoPessoa::find();

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
            'idbo_pessoa' => $this->idbo_pessoa,
            'idbo' => $this->idbo,
            'idpessoa' => $this->idpessoa,
            'idpessoa_tipo' => $this->idpessoa_tipo,
        ]);

        return $dataProvider;
    }
}
