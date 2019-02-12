<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%statistics_order}}".
 *
 * @property integer $id
 * @property string $date
 * @property integer $order_num
 * @property string $create_time
 * @property string $last_time
 */
class StatisticsOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%statistics_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date', 'create_time', 'last_time'], 'safe'],
            [['order_num'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'order_num' => 'Order Num',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
        ];
    }
}
