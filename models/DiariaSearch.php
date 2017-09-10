<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Diaria;

/**
 * DiariaSearch represents the model behind the search form about `app\models\Diaria`.
 */
class DiariaSearch extends Diaria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iddiaria', 'extra'], 'integer'],
            [['data_ini', 'hora_ini', 'data_fin', 'hora_fin', 'servico', 'local'], 'safe'],
            [['qtd_policiais', 'valor'], 'number'],
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
        $query = Diaria::find();

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
            'iddiaria' => $this->iddiaria,
            'data_ini' => $this->data_ini,
            'hora_ini' => $this->hora_ini,
            'data_fin' => $this->data_fin,
            'hora_fin' => $this->hora_fin,
            'qtd_policiais' => $this->qtd_policiais,
            'valor' => $this->valor,
            'extra' => $this->extra,
        ]);

        $query->andFilterWhere(['like', 'servico', $this->servico])
            ->andFilterWhere(['like', 'local', $this->local]);

        return $dataProvider;
    }
}
