<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $idusuario
 * @property string $login
 * @property string $senha
 * @property string $acess_token
 * @property string $auth_key
 * @property string $papel
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    public $senha_repeat;
    
    //public $papel;-> foi criado no banco de dados
    
    public static $papeis = [
        'admin' => 'Administrador',
        'comandante' => 'Comandante',
        'secretario' => 'Secretario',
        
    ];

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_LOGIN = 'login';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if ($insert || !empty($this->senha)) {
            $this->senha = sha1($this->senha);
        } else {
            $this->senha = $this->attributes['senha'];
        }
        if ($insert) {
            $this->acess_token = \Yii::$app->security->generateRandomString(80);
            $this->auth_key = \Yii::$app->security->generateRandomString(80);
        }
        return parent::beforeSave($insert);
    }

    public function rules() {
        return [
            [['login', 'senha', 'papel'], 'required', 'on'=> self::SCENARIO_CREATE],
            [['login', 'papel'], 'required', 'on'=> self::SCENARIO_UPDATE],
            [['login', 'senha', 'papel'], 'string', 'max' => 45],
            [['acess_token', 'auth_key'], 'string', 'max' => 80],
            [['senha_repeat'], 'safe'],
            [['senha_repeat'], 'compare', 'compareAttribute' => 'senha'],
            [['login'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idusuario' => Yii::t('app', 'Idusuario'),
            'login' => Yii::t('app', 'Login'),
            'senha' => Yii::t('app', 'Senha'),
            'senha_repeat' => Yii::t('app', 'Repetição de senha'),
            'acess_token' => Yii::t('app', 'Acess Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        $user = self::find()->where(['idusuario' => $id])->one();
        if (!is_null($user)) {
            return $user;
        }
        /*
          foreach (self::$users as $user) {
          if ($user['accessToken'] === $token) {
          return new static($user);
          }
          }
         */
        return null;
    }

//return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        $user = self::find()->where(['acess_token' => $token])->one();
        if (!is_null($user)) {
            return $user;
        }
        /*
          foreach (self::$users as $user) {
          if ($user['accessToken'] === $token) {
          return new static($user);
          }
          }
         */
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $user = self::find()->where(['login' => $username])->one();
        if (!is_null($user)) {
            return $user;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->idusuario;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($auth_key) {
        //return $this->auth_key === $auth_Key;
        return true;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($senha) {
        return $this->senha === sha1($senha);
    }

}

// 1º - gerar o model no gii depois de criado a tabela usuario no banco
// 2º - gerar o crud dessa tabela
// 3º - retirar o  <?= $form->field($model, 'acess_token')->textInput(['maxlength' => true]) <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true])
// da form de usuarios deixar só login e senha
// 4º - criar a função public static function beforeSave($insert) são os filtros
// 5º - comenta ou exclui na view e no index da pasta view de usuario o acess_token, auth_key para não aparecer para o usuário - questão da prova  
// 6º - colocar isso na classe usuarios implements \yii\web\IdentityInterface
// 7º - no validatorsha1 substituir Password($senha);