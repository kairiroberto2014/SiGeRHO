<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bo_crime".
 *
 * @property string $idbo_crime
 * @property string $idbo
 * @property string $idcrime
 *
 * @property Bo $idbo0
 * @property Crime $idcrime0
 */
class BoCrime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bo_crime';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idbo', 'idcrime'], 'required'],
            [['idbo', 'idcrime'], 'integer'],
            [['idbo'], 'exist', 'skipOnError' => true, 'targetClass' => Bo::className(), 'targetAttribute' => ['idbo' => 'idbo']],
            [['idcrime'], 'exist', 'skipOnError' => true, 'targetClass' => Crime::className(), 'targetAttribute' => ['idcrime' => 'idcrime']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idbo_crime' => Yii::t('app', 'Idbo Crime'),
            'idbo' => Yii::t('app', 'Idbo'),
            'idcrime' => Yii::t('app', 'Idcrime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdbo0()
    {
        return $this->hasOne(Bo::className(), ['idbo' => 'idbo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcrime0()
    {
        return $this->hasOne(Crime::className(), ['idcrime' => 'idcrime']);
    }
}
