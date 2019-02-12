<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%goods_sku}}".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $goods_category_attr_id
 * @property integer $price
 * @property string $merchant_standard_json
 * @property string $merchant_optional_json
 * @property string $platform_standard_json
 * @property string $platform_optional_json
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class GoodsSku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_sku}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'price', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['goods_category_attr_id'], 'string', 'max' => 32],
            [['merchant_standard_json', 'merchant_optional_json', 'platform_standard_json', 'platform_optional_json'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'goods_category_attr_id' => 'Goods Category Attr ID',
            'price' => 'Price',
            'merchant_standard_json' => 'Merchant Standard Json',
            'merchant_optional_json' => 'Merchant Optional Json',
            'platform_standard_json' => 'Platform Standard Json',
            'platform_optional_json' => 'Platform Optional Json',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
