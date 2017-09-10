<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "crime".
 *
 * @property string $idcrime
 * @property string $nome
 * @property string $artigo
 * @property string $lei
 *
 * @property BoCrime[] $boCrimes
 */
class Crime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crime';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['nome', 'artigo', 'lei'], 'required'],
            [['nome', 'artigo', 'lei'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcrime' => Yii::t('app', 'Idcrime'),
            'nome' => Yii::t('app', 'Nome'),
            'artigo' => Yii::t('app', 'Artigo'),
            'lei' => Yii::t('app', 'Lei'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoCrimes()
    {
        return $this->hasMany(BoCrime::className(), ['idcrime' => 'idcrime']);
    }
}
