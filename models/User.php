<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\mongodb\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use yii\mongodb\Query;
use yii\data\ActiveDataProvider;

class User extends \yii\mongodb\ActiveRecord implements \yii\web\IdentityInterface
{

    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $email;
    public $admin;
    public $bloqueado;
    public $eliminado;


    public static function collectionName()
    {
        return 'Usuario';
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max'=>100]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'username'=> 'Username',
            'password'=> 'Password',
            'email' => 'Email',
        ];
    }

    public function attributes()
    {
         return [
             '_id',
            //   'id',
            //    'username',
            //    'password',
            //    'authKey',
            //    'accessToken',
            //    'email'
         ];
    }

    public static function registerUser($username, $email, $password)
    {
        $query = new Query();
        $response = $query->select(['id'])
            ->from('Usuario')
            ->max('id');
        $response++;

        $values =[
            'id' => $response,
            'username' => $username,
            'password'=> sha1($password),
            'authKey' => 'test'.$response.'key',
            'accessToken' => $response.'-token',
            'email' => $email,
            'admin' => false,
            'bloqueado' => false,
            'eliminado' => false,
        ];
       
       $collection = Yii::$app->mongodb->getCollection('Usuario');
       return $collection->insert($values);

    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' =>$id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
        
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }

    public static function allUsers()
    {
        $data = new ActiveDataProvider([
            'query' => static::find(),
            'pagination' => [
                'pageSize' => 20,
        ],
        ]);

        return $data;
    }

    public static function lockUnlock($id, $actualState)
    {
       $collection = Yii::$app->mongodb->getCollection('Usuario');
       return $collection->update(['id' => (int)$id], ['bloqueado' => !$actualState] );
    }

    public static function deleteUser($id)
    {
       $collection = Yii::$app->mongodb->getCollection('Usuario');
       return $collection->update(['id' => (int)$id], ['eliminado' => true] );
    }

}
