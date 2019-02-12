<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_goods_category".
 *
 * @property integer $id
 * @property integer $service_providers_id
 * @property string $name
 * @property integer $is_system
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_goods_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_providers_id','flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    public function getGoodsCategoryAttr() {
        return $this -> hasMany(GoodsCategoryAttr::className(), ['goods_category_id' => 'id']) -> onCondition(['flag' => FLAG_YES]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_providers_id' => 'Service Providers ID',
            'name' => 'Name',
            'is_system' => 'Is System',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
