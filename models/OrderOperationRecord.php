<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_order_operation_record".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $date
 * @property integer $operation_type
 * @property integer $role
 * @property integer $operator_id
 * @property string $data_file
 * @property string $content
 * @property string $new_order_no
 * @property string $old_order_no
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class OrderOperationRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_order_operation_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'operation_type', 'role', 'operator_id', 'flag'], 'integer'],
            [['date', 'create_time', 'last_time'], 'safe'],
            [['content'], 'string'],
            [['data_file'], 'string', 'max' => 128],
            [['new_order_no', 'old_order_no'], 'string', 'max' => 64],
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
            'date' => 'Date',
            'operation_type' => 'Operation Type',
            'role' => 'Role',
            'operator_id' => 'Operator ID',
            'data_file' => 'Data File',
            'content' => 'Content',
            'new_order_no' => 'New Order No',
            'old_order_no' => 'Old Order No',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
