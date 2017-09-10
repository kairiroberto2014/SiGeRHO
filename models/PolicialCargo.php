<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "policial_cargo".
 *
 * @property string $idpolicial_cargo
 * @property string $idpolicial
 * @property string $idcargo
 * @property string $inicio
 * @property string $fim
 *
 * @property Policial $idpolicial0
 * @property Cargo $idcargo0
 */
class PolicialCargo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policial_cargo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial', 'idcargo', 'inicio'], 'required'],
            [['idpolicial', 'idcargo'], 'integer'],
            [['inicio', 'fim'], 'safe'],
            [['idpolicial'], 'exist', 'skipOnError' => true, 'targetClass' => Policial::className(), 'targetAttribute' => ['idpolicial' => 'idpolicial']],
            [['idcargo'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::className(), 'targetAttribute' => ['idcargo' => 'idcargo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpolicial_cargo' => Yii::t('app', 'Idpolicial Cargo'),
            'idpolicial' => Yii::t('app', 'Idpolicial'),
            'idcargo' => Yii::t('app', 'Idcargo'),
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
    public function getIdcargo0()
    {
        return $this->hasOne(Cargo::className(), ['idcargo' => 'idcargo']);
    }
}
