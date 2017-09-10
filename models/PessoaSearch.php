<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pessoa;

/**
 * PessoaSearch represents the model behind the search form about `app\models\Pessoa`.
 */
class PessoaSearch extends Pessoa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpessoa', 'idade'], 'integer'],
            [['nome', 'nascimento', 'rg', 'cpf', 'telefone', 'endereco', 'pai', 'mae', 'estado_civil'], 'safe'],
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
        $query = Pessoa::find();

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
            'idpessoa' => $this->idpessoa,
            'nascimento' => $this->nascimento,
            'idade' => $this->idade,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'rg', $this->rg])
            ->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'telefone', $this->telefone])
            ->andFilterWhere(['like', 'endereco', $this->endereco])
            ->andFilterWhere(['like', 'pai', $this->pai])
            ->andFilterWhere(['like', 'mae', $this->mae])
            ->andFilterWhere(['like', 'estado_civil', $this->estado_civil]);

        return $dataProvider;
    }
}
