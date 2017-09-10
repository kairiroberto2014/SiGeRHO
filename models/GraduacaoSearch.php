<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Graduacao;

/**
 * GraduacaoSearch represents the model behind the search form about `app\models\Graduacao`.
 */
class GraduacaoSearch extends Graduacao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idgraduacao'], 'integer'],
            [['nome_graduacao'], 'safe'],
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
        $query = Graduacao::find();

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
            'idgraduacao' => $this->idgraduacao,
        ]);

        $query->andFilterWhere(['like', 'nome_graduacao', $this->nome_graduacao]);

        return $dataProvider;
    }
}
