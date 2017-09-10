<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unidade".
 *
 * @property string $idunidade
 * @property string $nome
 * @property string $cidade
 *
 * @property PolicialUnidade[] $policialUnidades
 */
class Unidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unidade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome', 'cidade'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idunidade' => Yii::t('app', 'Idunidade'),
            'nome' => Yii::t('app', 'Unidade'),
            'cidade' => Yii::t('app', 'Cidade'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicialUnidades()
    {
        return $this->hasMany(PolicialUnidade::className(), ['idunidade' => 'idunidade']);
    }
}
