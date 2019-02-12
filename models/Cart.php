<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_cart".
 *
 * @property integer $id
 * @property integer $demand_person_id
 * @property integer $goods_id
 * @property integer $goods_sku_id
 * @property integer $num
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['demand_person_id', 'goods_id', 'goods_sku_id', 'num', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'demand_person_id' => 'Demand Person ID',
            'goods_id' => 'Goods ID',
            'goods_sku_id' => 'Goods Sku ID',
            'num' => 'Num',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
