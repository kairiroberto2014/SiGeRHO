<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diaria".
 *
 * @property string $iddiaria
 * @property string $data_ini
 * @property string $hora_ini
 * @property string $data_fin
 * @property string $hora_fin
 * @property string $servico
 * @property string $local
 * @property double $qtd_policiais
 * @property double $valor
 * @property integer $extra
 *
 * @property PolicialDiaria[] $policialDiarias
 */
class Diaria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diaria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_ini', 'hora_ini', 'data_fin', 'hora_fin'], 'safe'],
            [['qtd_policiais', 'valor'], 'number'],
            [['extra'], 'integer'],
            [['servico', 'local'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iddiaria' => Yii::t('app', 'Iddiaria'),
            'data_ini' => Yii::t('app', 'Data Ini'),
            'hora_ini' => Yii::t('app', 'Hora Ini'),
            'data_fin' => Yii::t('app', 'Data Fin'),
            'hora_fin' => Yii::t('app', 'Hora Fin'),
            'servico' => Yii::t('app', 'Servico'),
            'local' => Yii::t('app', 'Local'),
            'qtd_policiais' => Yii::t('app', 'Qtd Policiais'),
            'valor' => Yii::t('app', 'Valor'),
            'extra' => Yii::t('app', 'Extra'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicialDiarias()
    {
        return $this->hasMany(PolicialDiaria::className(), ['iddiaria' => 'iddiaria']);
    }
}
