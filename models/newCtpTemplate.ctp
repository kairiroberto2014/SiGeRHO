<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use \Imagine\Image;

/**
 * This is the model class for table "policial".
 *
 * @property string $idpolicial
 * @property string $nome
 * @property string $cpf
 * @property string $matricula
 * @property string $foto
 * @property string $admissao
 *
 * @property BoPolicial[] $boPolicials
 * @property Oficial[] $oficials
 * @property PolicialDiaria[] $policialDiarias
 * @property PolicialHistorico[] $policialHistoricos
 * @property PolicialUnidade[] $policialUnidades
 * @property Praca[] $pracas
 */
class Policial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public $flag;
        
    public static function tableName()
    {
        return 'policial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flag'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['admissao'], 'safe'],
            [['nome', 'email'], 'string', 'max' => 100],
            [['cpf'], 'string', 'max' => 11],
            [['matricula'], 'string', 'max' => 7],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpolicial' => Yii::t('app', 'Idpolicial'),
            'nome' => Yii::t('app', 'Nome'),
            'cpf' => Yii::t('app', 'Cpf'),
            'matricula' => Yii::t('app', 'Matricula'),
            'email' => Yii::t('app', 'Email'),
            'admissao' => Yii::t('app', 'Admissao'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoPolicials()
    {
        return $this->hasMany(BoPolicial::className(), ['idpolicial' => 'idpolicial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOficials()
    {
        return $this->hasMany(Oficial::className(), ['idpolicial' => 'idpolicial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicialDiarias()
    {
        return $this->hasMany(PolicialDiaria::className(), ['idpolicial' => 'idpolicial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicialHistoricos()
    {
        return $this->hasMany(PolicialHistorico::className(), ['idpolicial' => 'idpolicial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicialUnidades()
    {
        return $this->hasMany(PolicialUnidade::className(), ['idpolicial' => 'idpolicial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPracas()
    {
        return $this->hasMany(Praca::className(), ['idpolicial' => 'idpolicial']);
    }
    
    public function getFotoLink() {
        //return Yii::getAlias('@webroot/uploads/') . $this->idpolicial . '.png';
        return Yii::getAlias('@webroot') . "/uploads/" . $this->idpolicial . '.jpg';
    }
    
    public function getFotoPath() {
        return Yii::getAlias('@web') . "/uploads/" . $this->idpolicial . '.jpg';
    }


    public function upload() {
        if ($this->validate()) {
            //$this->flag->saveAs(Yii::getAlias('@web/uploads/') 
            //$this->flag->baseName . '.' . $this->foto->extension);
            $this->flag->saveAs($this->getFotoLink());
            //\yii\imagine\Image::thumbnail($this->getFotoLink(), 30, 30, $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND);
            return true;
        } else {
            return false;
        }
    }
    
    
    
}
