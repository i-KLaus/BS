<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $code;
    public $account;
    public $pwd;
    public $name;
    public $address;
    public $operating_address;
    public $business_license;
    public $legal_person_name;
    public $legal_person_phone;
    public $legal_person_id_card_zm;
    public $legal_person_id_card_fm;
    public $contact_name;
    public $contact_phone;
    public $contact_id_card_zm;
    public $contact_id_card_fm;
    public $account_name;
    public $settlement_account;
    public $bank_info;
    public $account_opening_permit;
    public $status;
    public $reject_reason;
    public $reject_time;
    public $apply_time;
    public $forget_code;
    public $if_star;
    public $if_star_union;
    public $create_time;
    public $last_time;
    public $flag;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user =  ServiceProviders::find() -> where(['and', ['id' => $id, 'flag' => FLAG_YES]]) -> one();
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
        $user = ServiceProviders::find() -> where(['and', ['account' => $username, 'flag' => FLAG_YES]]) -> one();

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
