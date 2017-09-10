<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oficial".
 *
 * @property string $idoficial
 * @property string $idpolicial
 * @property string $idposto
 *
 * @property Policial $idpolicial0
 * @property Posto $idposto0
 */
class Oficial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oficial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial', 'idposto'], 'integer'],
            [['inicio', 'fim'], 'safe'],
            [['idpolicial'], 'exist', 'skipOnError' => true, 'targetClass' => Policial::className(), 'targetAttribute' => ['idpolicial' => 'idpolicial']],
            [['idposto'], 'exist', 'skipOnError' => true, 'targetClass' => Posto::className(), 'targetAttribute' => ['idposto' => 'idposto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idoficial' => Yii::t('app', 'Idoficial'),
            'idpolicial' => Yii::t('app', 'Idpolicial'),
            'idposto' => Yii::t('app', 'Idposto'),
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
    public function getIdposto0()
    {
        return $this->hasOne(Posto::className(), ['idposto' => 'idposto']);
    }
}
