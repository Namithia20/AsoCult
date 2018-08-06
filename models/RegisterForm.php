<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username, email and password are both required
            [['username','email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }


    public function register()
    {
        //check user exist
        $user = $this->getUser();
        if(!$user)
        {
            return User::registerUser($this->username, $this->email, $this->password);         
        }
        else
        {$this->addError('username','Already exist that username.'); return false;}
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
