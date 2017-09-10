<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "graduacao".
 *
 * @property string $idgraduacao
 * @property string $nome_graduacao
 *
 * @property Praca[] $pracas
 */
class Graduacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'graduacao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome_graduacao'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idgraduacao' => Yii::t('app', 'Idgraduacao'),
            'nome_graduacao' => Yii::t('app', 'Nome Graduacao'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPracas()
    {
        return $this->hasMany(Praca::className(), ['idgraduacao' => 'idgraduacao']);
    }
}
