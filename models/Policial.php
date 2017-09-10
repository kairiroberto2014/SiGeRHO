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
 * @property string $email
 * @property string $admissao
 *  * @property string $nascimento
 * @property string $pai
 * @property string $mae
 * @property string $naturalidade
 * @property string $rg
 * @property string $estado_civil
 * @property double $altura
 * @property string $cor
 * @property string $olhos
 * @property string $boca
 * @property string $nariz
 * @property string $rosto
 * @property string $instrucao
 * @property string $profissao
 * @property string $procedencia
 * @property string $exclusao
 *
 * @property BoPolicial[] $boPolicials
 * @property Oficial[] $oficials
 * @property PolicialCargo[] $policialCargos
 * @property PolicialCurso[] $policialCursos
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
            
            [['admissao', 'nascimento'], 'safe'],
            [['altura'], 'number'],
            [['nome', 'email', 'pai', 'mae'], 'string', 'max' => 100],
            [['cpf'], 'string', 'max' => 11],
            [['matricula'], 'string', 'max' => 7],
            [['naturalidade', 'estado_civil', 'cor', 'olhos', 'boca', 'nariz', 'rosto', 'instrucao', 'profissao', 'procedencia', 'exclusao'], 'string', 'max' => 45],
            [['rg'], 'string', 'max' => 20],
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
            'nascimento' => Yii::t('app', 'Nascimento'),
            'pai' => Yii::t('app', 'Pai'),
            'mae' => Yii::t('app', 'Mae'),
            'naturalidade' => Yii::t('app', 'Naturalidade'),
            'rg' => Yii::t('app', 'Rg'),
            'estado_civil' => Yii::t('app', 'Estado Civil'),
            'altura' => Yii::t('app', 'Altura'),
            'cor' => Yii::t('app', 'Cor'),
            'olhos' => Yii::t('app', 'Olhos'),
            'boca' => Yii::t('app', 'Boca'),
            'nariz' => Yii::t('app', 'Nariz'),
            'rosto' => Yii::t('app', 'Rosto'),
            'instrucao' => Yii::t('app', 'Instrucao'),
            'profissao' => Yii::t('app', 'Profissao'),
            'procedencia' => Yii::t('app', 'Procedencia'),
            'exclusao' => Yii::t('app', 'Exclusao'),
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
    public function getPolicialCargos()
    {
        return $this->hasMany(PolicialCargo::className(), ['idpolicial' => 'idpolicial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicialCursos()
    {
        return $this->hasMany(PolicialCurso::className(), ['idpolicial' => 'idpolicial']);
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
            $this->flag->saveAs($this->getFotoLink());
            \yii\imagine\Image::thumbnail($this->getFotoLink(), 100, 100, 
            $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)
            ->save($this->getFotoLink(), ['jpeg quality' => 100]);
        }
        return true;
    }
    
}
