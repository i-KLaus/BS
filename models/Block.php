<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%block}}".
 *
 * @property integer $id
 * @property string $name
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
class Block extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%block}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'last_time'], 'safe'],
            [['flag'], 'integer'],
            [['name'], 'string', 'max' => 128],
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
            'name' => 'Name',
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
}
