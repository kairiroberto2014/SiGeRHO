<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "policial_diaria".
 *
 * @property string $idpolicial_diaria
 * @property string $idpolicial
 * @property string $iddiaria
 * @property integer $executada
 * @property integer $justificada
 *
 * @property Policial $idpolicial0
 * @property Diaria $iddiaria0
 */
class PolicialDiaria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policial_diaria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial', 'iddiaria', 'executada', 'justificada'], 'integer'],
            [['idpolicial'], 'exist', 'skipOnError' => true, 'targetClass' => Policial::className(), 'targetAttribute' => ['idpolicial' => 'idpolicial']],
            [['iddiaria'], 'exist', 'skipOnError' => true, 'targetClass' => Diaria::className(), 'targetAttribute' => ['iddiaria' => 'iddiaria']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpolicial_diaria' => Yii::t('app', 'Idpolicial Diaria'),
            'idpolicial' => Yii::t('app', 'Idpolicial'),
            'iddiaria' => Yii::t('app', 'Iddiaria'),
            'executada' => Yii::t('app', 'Executada'),
            'justificada' => Yii::t('app', 'Justificada'),
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
    public function getIddiaria0()
    {
        return $this->hasOne(Diaria::className(), ['iddiaria' => 'iddiaria']);
    }
}
