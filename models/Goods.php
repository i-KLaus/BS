<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property integer $service_providers_id
 * @property integer $pre_category_id
 * @property integer $category_id
 * @property string $name
 * @property string $goods_img
 * @property string $content
 * @property integer $status
 * @property string $reject_reason
 * @property string $reject_time
 * @property integer $min_price
 * @property integer $max_price
 * @property integer $merchant_id
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_providers_id', 'pre_category_id', 'category_id', 'status', 'min_price', 'max_price', 'merchant_id', 'flag'], 'integer'],
            [['content'], 'string'],
            [['reject_time', 'create_time', 'last_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['goods_img', 'reject_reason'], 'string', 'max' => 128],
        ];

    }
    public function getPreCategory() {
        return $this -> hasOne(Category::className(), ['id' => 'pre_category_id']);
    }

    public function getCategory() {
        return $this -> hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getServiceProviders() {
        return $this -> hasOne(ServiceProviders::className(), ['id' => 'service_providers_id']);
    }

    public function getMerchant() {
        return $this -> hasOne(Merchant::className(), ['id' => 'merchant_id']);
    }

    public function getGoodsSku() {
        return $this -> hasMany(GoodsSku::className(), ['goods_id' => 'id']);
    }
    public function getStore(){
        return $this->hasMany(Store::className(),['goods_id'=>'id']);

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_providers_id' => 'Service Providers ID',
            'pre_category_id' => 'Pre Category ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'goods_img' => 'Goods Img',
            'content' => 'Content',
            'status' => 'Status',
            'reject_reason' => 'Reject Reason',
            'reject_time' => 'Reject Time',
            'min_price' => 'Min Price',
            'max_price' => 'Max Price',
            'merchant_id' => 'Merchant ID',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
