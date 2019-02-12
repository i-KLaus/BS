<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_merchant_code".
 *
 * @property integer $id
 * @property integer $service_providers_id
 * @property integer $merchant_id
 * @property string $code
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class MerchantCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_merchant_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_providers_id', 'merchant_id', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['code'], 'string', 'max' => 64],
            [['code'], 'unique']
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
            'merchant_id' => 'Merchant ID',
            'code' => 'Code',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
