<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_service_providers".
 *
 * @property integer $id
 * @property integer $code
 * @property string $account
 * @property string $pwd
 * @property string $name
 * @property string $address
 * @property string $operating_address
 * @property string $business_license
 * @property string $legal_person_name
 * @property string $legal_person_phone
 * @property string $legal_person_id_card_zm
 * @property string $legal_person_id_card_fm
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_id_card_zm
 * @property string $contact_id_card_fm
 * @property string $account_name
 * @property string $settlement_account
 * @property string $bank_info
 * @property string $account_opening_permit
 * @property integer $status
 * @property string $reject_reason
 * @property string $reject_time
 * @property string $apply_time
 * @property string $forget_code
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class ServiceProviders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_service_providers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'status', 'flag'], 'integer'],
            [['reject_time', 'apply_time', 'create_time', 'last_time'], 'safe'],
            [['account', 'pwd', 'legal_person_name', 'legal_person_phone', 'contact_name', 'contact_phone'], 'string', 'max' => 32],
            [['name', 'business_license', 'legal_person_id_card_zm', 'legal_person_id_card_fm', 'contact_id_card_zm', 'contact_id_card_fm', 'settlement_account', 'account_opening_permit'], 'string', 'max' => 64],
            [['address', 'operating_address', 'account_name', 'bank_info', 'reject_reason'], 'string', 'max' => 128],
            [['forget_code'], 'string', 'max' => 12],
            [['account'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'account' => 'Account',
            'pwd' => 'Pwd',
            'name' => 'Name',
            'address' => 'Address',
            'operating_address' => 'Operating Address',
            'business_license' => 'Business License',
            'legal_person_name' => 'Legal Person Name',
            'legal_person_phone' => 'Legal Person Phone',
            'legal_person_id_card_zm' => 'Legal Person Id Card Zm',
            'legal_person_id_card_fm' => 'Legal Person Id Card Fm',
            'contact_name' => 'Contact Name',
            'contact_phone' => 'Contact Phone',
            'contact_id_card_zm' => 'Contact Id Card Zm',
            'contact_id_card_fm' => 'Contact Id Card Fm',
            'account_name' => 'Account Name',
            'settlement_account' => 'Settlement Account',
            'bank_info' => 'Bank Info',
            'account_opening_permit' => 'Account Opening Permit',
            'status' => 'Status',
            'reject_reason' => 'Reject Reason',
            'reject_time' => 'Reject Time',
            'apply_time' => 'Apply Time',
            'forget_code' => 'Forget Code',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
