<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_goods_category_attr".
 *
 * @property integer $id
 * @property integer $service_providers_id
 * @property integer $goods_category_id
 * @property string $attr
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class GoodsCategoryAttr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_goods_category_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_providers_id', 'goods_category_id', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['attr'], 'string', 'max' => 64],
        ];
    }

    public function getGoodsCategory() {
        return $this -> hasOne(GoodsCategory::className(), ['id' => 'goods_category_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_providers_id' => 'Service Providers ID',
            'goods_category_id' => 'Goods Category ID',
            'attr' => 'Attr',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
