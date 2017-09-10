<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bo_policial".
 *
 * @property string $idbo_policial
 * @property string $idbo
 * @property string $idpolicial
 *
 * @property Bo $idbo0
 * @property Policial $idpolicial0
 */
class BoPolicial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bo_policial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idbo', 'idpolicial'], 'required'],
            [['idbo', 'idpolicial'], 'integer'],
            [['cmt'], 'boolean'],
            [['idbo'], 'exist', 'skipOnError' => true, 'targetClass' => Bo::className(), 'targetAttribute' => ['idbo' => 'idbo']],
            [['idpolicial'], 'exist', 'skipOnError' => true, 'targetClass' => Policial::className(), 'targetAttribute' => ['idpolicial' => 'idpolicial']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idbo_policial' => Yii::t('app', 'Idbo Policial'),
            'idbo' => Yii::t('app', 'Idbo'),
            'idpolicial' => Yii::t('app', 'Idpolicial'),
            'cmt' => Yii::t('app', 'Cmt'),
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
    public function getIdpolicial0()
    {
        return $this->hasOne(Policial::className(), ['idpolicial' => 'idpolicial']);
    }
}
