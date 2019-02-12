<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%order_sku}}".
 *
 * @property integer $id
 * @property integer $service_providers_id
 * @property integer $order_id
 * @property integer $goods_id
 * @property integer $goods_sku_id
 * @property integer $goods_type
 * @property integer $num
 * @property integer $price
 * @property integer $implement_money
 * @property integer $status
 * @property string $merchant_standard_json
 * @property string $merchant_optional_json
 * @property string $platform_standard_json
 * @property string $platform_optional_json
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class OrderSku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_sku}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_providers_id', 'order_id', 'goods_id', 'goods_sku_id', 'goods_type', 'num', 'price', 'implement_money', 'status', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
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
            'service_providers_id' => 'Service Providers ID',
            'order_id' => 'Order ID',
            'goods_id' => 'Goods ID',
            'goods_sku_id' => 'Goods Sku ID',
            'goods_type' => 'Goods Type',
            'num' => 'Num',
            'price' => 'Price',
            'implement_money' => 'Implement Money',
            'status' => 'Status',
            'merchant_standard_json' => 'Merchant Standard Json',
            'merchant_optional_json' => 'Merchant Optional Json',
            'platform_standard_json' => 'Platform Standard Json',
            'platform_optional_json' => 'Platform Optional Json',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
    public function getGoods() {
        return $this -> hasOne(Goods::className(), ['id' => 'goods_id']);
    }

    public function getGoodsSku() {
        return $this -> hasOne(GoodsSku::className(), ['id' => 'goods_sku_id']);
    }

    public function getSubCategory() {
        return $this -> hasOne(Category::className(), ['id' => 'category_id']) -> viaTable(Goods::tableName(), ['id' => 'goods_id']);
    }

    public function getCategory() {
        return $this -> hasOne(Category::className(), ['id' => 'pre_category_id']) -> viaTable(Goods::tableName(), ['id' => 'goods_id']);
    }

    public function getMerchant() {
        return $this -> hasOne(Merchant::className(), ['id' => 'merchant_id']) -> viaTable(Goods::tableName(), ['id' => 'goods_id']);
    }
}
