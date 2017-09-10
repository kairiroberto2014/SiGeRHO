<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posto".
 *
 * @property string $idposto
 * @property string $nome_posto
 *
 * @property Oficial[] $oficials
 */
class Posto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome_posto'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idposto' => Yii::t('app', 'Idposto'),
            'nome_posto' => Yii::t('app', 'Nome Posto'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOficials()
    {
        return $this->hasMany(Oficial::className(), ['idposto' => 'idposto']);
    }
}
