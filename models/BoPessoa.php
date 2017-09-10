<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bo_pessoa".
 *
 * @property string $idbo_pessoa
 * @property string $idbo
 * @property string $idpessoa
 * @property string $idpessoa_tipo
 *
 * @property Bo $idbo0
 * @property Pessoa $idpessoa0
 * @property PessoaTipo $idpessoaTipo
 */
class BoPessoa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bo_pessoa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idbo'], 'required'],
            [['idbo', 'idpessoa', 'idpessoa_tipo'], 'integer'],
            [['idbo'], 'exist', 'skipOnError' => true, 'targetClass' => Bo::className(), 'targetAttribute' => ['idbo' => 'idbo']],
            [['idpessoa'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoa::className(), 'targetAttribute' => ['idpessoa' => 'idpessoa']],
            [['idpessoa_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => PessoaTipo::className(), 'targetAttribute' => ['idpessoa_tipo' => 'idpessoa_tipo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idbo_pessoa' => Yii::t('app', 'Idbo Pessoa'),
            'idbo' => Yii::t('app', 'Idbo'),
            'idpessoa' => Yii::t('app', 'Idpessoa'),
            'idpessoa_tipo' => Yii::t('app', 'Idpessoa Tipo'),
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
    public function getIdpessoa0()
    {
        return $this->hasOne(Pessoa::className(), ['idpessoa' => 'idpessoa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdpessoaTipo()
    {
        return $this->hasOne(PessoaTipo::className(), ['idpessoa_tipo' => 'idpessoa_tipo']);
    }
}
