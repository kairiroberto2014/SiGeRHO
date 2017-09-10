<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pessoa".
 *
 * @property string $idpessoa
 * @property string $nome
 * @property string $nascimento
 * @property string $rg
 * @property string $cpf
 * @property string $telefone
 * @property string $endereco
 *
 * @property BoPessoa[] $boPessoas
 */
class Pessoa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pessoa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nascimento'], 'safe'],
            [['idade'], 'integer'],
            [['nome', 'endereco', 'pai', 'mae'], 'string', 'max' => 150],
            [['rg'], 'string', 'max' => 30],
            [['cpf'], 'string', 'max' => 11],
            [['telefone'], 'string', 'max' => 20],
            [['estado_civil'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpessoa' => Yii::t('app', 'Idpessoa'),
            'nome' => Yii::t('app', 'Nome'),
            'nascimento' => Yii::t('app', 'Nascimento'),
            'rg' => Yii::t('app', 'Rg'),
            'cpf' => Yii::t('app', 'Cpf'),
            'telefone' => Yii::t('app', 'Telefone'),
            'endereco' => Yii::t('app', 'Endereco'),
            'pai' => Yii::t('app', 'Pai'),
            'mae' => Yii::t('app', 'Mae'),
            'idade' => Yii::t('app', 'Idade'),
            'estado_civil' => Yii::t('app', 'Estado Civil'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoPessoas()
    {
        return $this->hasMany(BoPessoa::className(), ['idpessoa' => 'idpessoa']);
    }
}
