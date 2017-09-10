<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "policial_unidade".
 *
 * @property string $idpolicial_unidade
 * @property string $idpolicial
 * @property string $idunidade
 * @property string $inicio
 * @property string $fim
 *
 * @property Policial $idpolicial0
 * @property Unidade $idunidade0
 */
class PolicialUnidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policial_unidade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial', 'idunidade', 'inicio'], 'required'],
            [['idpolicial', 'idunidade'], 'integer'],
            [['inicio', 'fim'], 'safe'],
            [['idpolicial'], 'exist', 'skipOnError' => true, 'targetClass' => Policial::className(), 'targetAttribute' => ['idpolicial' => 'idpolicial']],
            [['idunidade'], 'exist', 'skipOnError' => true, 'targetClass' => Unidade::className(), 'targetAttribute' => ['idunidade' => 'idunidade']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpolicial_unidade' => Yii::t('app', 'Idpolicial Unidade'),
            'idpolicial' => Yii::t('app', 'Idpolicial'),
            'idunidade' => Yii::t('app', 'Idunidade'),
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
    public function getIdunidade0()
    {
        return $this->hasOne(Unidade::className(), ['idunidade' => 'idunidade']);
    }
}
