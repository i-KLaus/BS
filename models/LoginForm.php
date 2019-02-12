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
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required', 'message' => '请输入您的帐号'],
            [['password'], 'required', 'message' => '请输入您的密码'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword(md5($this->password))) {
                $this->addError($attribute, '用户名或密码错误');
                return ;
            }

        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this -> username);
            if (!empty($this -> _user)) {
                Yii::$app -> session -> set('pid', $this -> _user -> id);
                Yii::$app -> session -> set('name', $this -> _user -> name);
                Yii::$app -> session -> set('is_admin', ACCOUNT_IS_ADMIN_YES);
            } else {
                $this -> _user = SubUser::findByUsername($this -> username);
                if (!empty($this -> _user)) {
                    Yii::$app -> session -> set('sub_id', $this -> _user -> id);
                    Yii::$app -> session -> set('name', $this -> _user -> name);
                    Yii::$app -> session -> set('pid', $this -> _user -> service_providers_id);
                    Yii::$app -> session -> set('is_admin', ACCOUNT_IS_ADMIN_NO);
                }
            }
        }

        return $this->_user;
    }
}
