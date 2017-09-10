<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pessoa_tipo".
 *
 * @property string $idpessoa_tipo
 * @property string $nome
 *
 * @property BoPessoa[] $boPessoas
 */
class PessoaTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pessoa_tipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpessoa_tipo' => Yii::t('app', 'Idpessoa Tipo'),
            'nome' => Yii::t('app', 'Nome'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoPessoas()
    {
        return $this->hasMany(BoPessoa::className(), ['idpessoa_tipo' => 'idpessoa_tipo']);
    }
}
