<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%store}}".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $block_id
 * @property string $name
 * @property string $business_license_name
 * @property string $province
 * @property string $province_code
 * @property string $city
 * @property string $city_code
 * @property string $area
 * @property string $area_code
 * @property string $address
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%store}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'block_id', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['name', 'business_license_name'], 'string', 'max' => 128],
            [['province', 'province_code', 'city', 'city_code', 'area', 'area_code'], 'string', 'max' => 32],
            [['address'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => 'Merchant ID',
            'block_id' => 'Block ID',
            'name' => 'Name',
            'business_license_name' => 'Business License Name',
            'province' => 'Province',
            'province_code' => 'Province Code',
            'city' => 'City',
            'city_code' => 'City Code',
            'area' => 'Area',
            'area_code' => 'Area Code',
            'address' => 'Address',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
    public function getGoods() {
        return $this -> hasOne(Goods::className(), ['id' => 'goods_id']);
    }
}
