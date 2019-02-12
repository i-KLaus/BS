<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%wechat_citys}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $area_name
 * @property integer $area_level
 * @property integer $sort
 * @property integer $enabled
 * @property string $city_code
 * @property string $pinyin
 */
class WechatCitys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_citys}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'area_level', 'sort', 'enabled'], 'integer'],
            [['area_name', 'city_code', 'pinyin'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'area_name' => 'Area Name',
            'area_level' => 'Area Level',
            'sort' => 'Sort',
            'enabled' => 'Enabled',
            'city_code' => 'City Code',
            'pinyin' => 'Pinyin',
        ];
    }
}
