<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_order_evaluate".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_sku_id
 * @property double $satisfaction
 * @property string $comment
 * @property string $img
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class OrderEvaluate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_order_evaluate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'order_sku_id', 'flag'], 'integer'],
            [['satisfaction'], 'number'],
            [['comment'], 'string'],
            [['create_time', 'last_time'], 'safe'],
            [['img'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'order_sku_id' => 'Order Sku ID',
            'satisfaction' => 'Satisfaction',
            'comment' => 'Comment',
            'img' => 'Img',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
