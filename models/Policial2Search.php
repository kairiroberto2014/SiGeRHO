<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Policial2;

/**
 * Policial2Search represents the model behind the search form about `app\models\Policial2`.
 */
class Policial2Search extends Policial2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial'], 'integer'],
            [['nome', 'cpf', 'matricula', 'email', 'admissao', 'nascimento', 'pai', 'mae', 'naturalidade', 'rg', 'estado_civil', 'cor', 'olhos', 'boca', 'nariz', 'rosto', 'instrucao', 'profissao', 'procedencia', 'exclusao'], 'safe'],
            [['altura'], 'number'],
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
        $query = Policial2::find();

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
            'idpolicial' => $this->idpolicial,
            'admissao' => $this->admissao,
            'nascimento' => $this->nascimento,
            'altura' => $this->altura,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'matricula', $this->matricula])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'pai', $this->pai])
            ->andFilterWhere(['like', 'mae', $this->mae])
            ->andFilterWhere(['like', 'naturalidade', $this->naturalidade])
            ->andFilterWhere(['like', 'rg', $this->rg])
            ->andFilterWhere(['like', 'estado_civil', $this->estado_civil])
            ->andFilterWhere(['like', 'cor', $this->cor])
            ->andFilterWhere(['like', 'olhos', $this->olhos])
            ->andFilterWhere(['like', 'boca', $this->boca])
            ->andFilterWhere(['like', 'nariz', $this->nariz])
            ->andFilterWhere(['like', 'rosto', $this->rosto])
            ->andFilterWhere(['like', 'instrucao', $this->instrucao])
            ->andFilterWhere(['like', 'profissao', $this->profissao])
            ->andFilterWhere(['like', 'procedencia', $this->procedencia])
            ->andFilterWhere(['like', 'exclusao', $this->exclusao]);

        return $dataProvider;
    }
}
