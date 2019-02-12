<?php

namespace app\models;

class SubUser extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $service_providers_id;
    public $account;
    public $name;
    public $pwd;
    public $right;
    public $create_time;
    public $last_time;
    public $flag;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user =  ServiceProvidersSubaccount::find() -> where(['and', ['id' => $id, 'flag' => FLAG_YES]]) -> one();
        if (!empty($user)) {
            return new static($user);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        $user = ServiceProvidersSubaccount::find() -> where(['and', ['account' => $username, 'flag' => FLAG_YES]]) -> one();

        if (!empty($user)) {
            return new static($user);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName() {
        return $this -> name;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->pwd === $password;
    }
}
