<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bo".
 *
 * @property string $idbo
 * @property string $data
 * @property string $hora
 * @property string $local
 * @property string $descricao
 *
 * @property BoCrime[] $boCrimes
 * @property BoPessoa[] $boPessoas
 * @property BoPolicial[] $boPolicials
 */
class Bo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data'], 'required'],
            [['data', 'hora', 'hora_trans'], 'safe'],
            [['descricao', 'material'], 'string'],
            [['local', 'viatura', 'pb', 'bairro'], 'string', 'max' => 45],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idbo' => Yii::t('app', 'Idbo'),
            'data' => Yii::t('app', 'Data'),
            'hora' => Yii::t('app', 'Hora'),
            'local' => Yii::t('app', 'Local'),
            'descricao' => Yii::t('app', 'Descricao'),
            'viatura' => Yii::t('app', 'Viatura'),
            'pb' => Yii::t('app', 'Pb'),
            'hora_trans' => Yii::t('app', 'Hora Trans'),
            'material' => Yii::t('app', 'Material'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoCrimes()
    {
        return $this->hasMany(BoCrime::className(), ['idbo' => 'idbo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoPessoas()
    {
        return $this->hasMany(BoPessoa::className(), ['idbo' => 'idbo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoPolicials()
    {
        return $this->hasMany(BoPolicial::className(), ['idbo' => 'idbo']);
    }
}
