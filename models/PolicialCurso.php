<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "policial_curso".
 *
 * @property string $idpolicial_curso
 * @property string $idpolicial
 * @property string $idcurso
 * @property string $instituicao
 * @property string $inicio
 * @property string $fim
 *
 * @property Policial $idpolicial0
 * @property Curso $idcurso0
 */
class PolicialCurso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policial_curso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpolicial', 'idcurso'], 'required'],
            [['idpolicial', 'idcurso', 'horas'], 'integer'],
            [['inicio', 'fim'], 'safe'],
            [['instituicao'], 'string', 'max' => 100],
            [['idpolicial'], 'exist', 'skipOnError' => true, 'targetClass' => Policial::className(), 'targetAttribute' => ['idpolicial' => 'idpolicial']],
            [['idcurso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['idcurso' => 'idcurso']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpolicial_curso' => Yii::t('app', 'Idpolicial Curso'),
            'idpolicial' => Yii::t('app', 'Idpolicial'),
            'idcurso' => Yii::t('app', 'Idcurso'),
            'instituicao' => Yii::t('app', 'Instituicao'),
            'inicio' => Yii::t('app', 'Inicio'),
            'fim' => Yii::t('app', 'Fim'),
            'horas' => Yii::t('app', 'Horas'),
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
    public function getIdcurso0()
    {
        return $this->hasOne(Curso::className(), ['idcurso' => 'idcurso']);
    }
}
