<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curso".
 *
 * @property string $idcurso
 * @property string $nome
 *
 * @property PolicialCurso[] $policialCursos
 */
class Curso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'curso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcurso' => Yii::t('app', 'Idcurso'),
            'nome' => Yii::t('app', 'Nome'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicialCursos()
    {
        return $this->hasMany(PolicialCurso::className(), ['idcurso' => 'idcurso']);
    }
}
