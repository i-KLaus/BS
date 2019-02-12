<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_service_providers_subaccount".
 *
 * @property integer $id
 * @property integer $service_providers_id
 * @property string $account
 * @property string $name
 * @property string $pwd
 * @property string $right
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class ServiceProvidersSubaccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_service_providers_subaccount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_providers_id', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['account', 'name'], 'string', 'max' => 32],
            [['pwd'], 'string', 'max' => 64],
            [['right'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_providers_id' => 'Service Providers ID',
            'account' => 'Account',
            'name' => 'Name',
            'pwd' => 'Pwd',
            'right' => 'Right',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
