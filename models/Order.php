<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $demand_person_id
 * @property integer $service_providers_id
 * @property string $order_no
 * @property integer $order_money
 * @property integer $status
 * @property integer $advance_payment_status
 * @property string $activity_start_time
 * @property string $activity_end_time
 * @property string $activity_name_json
 * @property string $activity_rule_json
 * @property string $activity_remark
 * @property string $activity_file
 * @property integer $evaluate_status
 * @property integer $before_cancel_status
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['demand_person_id', 'service_providers_id', 'order_money', 'status', 'advance_payment_status', 'evaluate_status', 'before_cancel_status', 'flag'], 'integer'],
            [['activity_start_time', 'activity_end_time', 'create_time', 'last_time'], 'safe'],
            [['order_no'], 'string', 'max' => 32],
            [['activity_name_json', 'activity_rule_json', 'activity_remark', 'activity_file'], 'string', 'max' => 225],
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
            'service_providers_id' => 'Service Providers ID',
            'order_no' => 'Order No',
            'order_money' => 'Order Money',
            'status' => 'Status',
            'advance_payment_status' => 'Advance Payment Status',
            'activity_start_time' => 'Activity Start Time',
            'activity_end_time' => 'Activity End Time',
            'activity_name_json' => 'Activity Name Json',
            'activity_rule_json' => 'Activity Rule Json',
            'activity_remark' => 'Activity Remark',
            'activity_file' => 'Activity File',
            'evaluate_status' => 'Evaluate Status',
            'before_cancel_status' => 'Before Cancel Status',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
    public function getOrderEvaluate() {
        return $this -> hasMany(OrderEvaluate::className(), ['order_id' => 'id']);
    }

    public function getOrderOperationRecord() {
        return $this -> hasMany(OrderOperationRecord::className(), ['order_id' => 'id']);
    }

    public function getOrderSku() {
        return $this -> hasMany(OrderSku::className(), ['order_id' => 'id']);
    }
}
