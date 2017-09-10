<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cargo".
 *
 * @property string $idcargo
 * @property string $nome
 *
 * @property PolicialCargo[] $policialCargos
 */
class Cargo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cargo';
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
            'idcargo' => Yii::t('app', 'Idcargo'),
            'nome' => Yii::t('app', 'Nome'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicialCargos()
    {
        return $this->hasMany(PolicialCargo::className(), ['idcargo' => 'idcargo']);
    }
}
