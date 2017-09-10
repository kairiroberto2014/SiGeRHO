<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "praca".
 *
 * @property string $idpraca
 * @property string $idpolicial
 * @property string $idgraduacao
 * @property string $numero_praca
 *
 * @property Policial $idpolicial0
 * @property Graduacao $idgraduacao0
 */
class Praca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'praca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial', 'idgraduacao'], 'integer'],
            [['numero_praca'], 'string', 'max' => 100],
            [['inicio', 'fim'], 'safe'],
            [['idpolicial'], 'exist', 'skipOnError' => true, 'targetClass' => Policial::className(), 'targetAttribute' => ['idpolicial' => 'idpolicial']],
            [['idgraduacao'], 'exist', 'skipOnError' => true, 'targetClass' => Graduacao::className(), 'targetAttribute' => ['idgraduacao' => 'idgraduacao']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpraca' => Yii::t('app', 'Idpraca'),
            'idpolicial' => Yii::t('app', 'Idpolicial'),
            'idgraduacao' => Yii::t('app', 'Idgraduacao'),
            'numero_praca' => Yii::t('app', 'Numero Praca'),
            'inicio' => Yii::t('app', 'Inicio'),
            'fim' => Yii::t('app', 'Fim'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdpolicial0()
    {
        return $this->hasOne(Policial::className(), ['idpolicial' => 'idpolicial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdgraduacao0()
    {
        return $this->hasOne(Graduacao::className(), ['idgraduacao' => 'idgraduacao']);
    }
}
