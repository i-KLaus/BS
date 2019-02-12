<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_operate_account".
 *
 * @property integer $id
 * @property string $name
 * @property string $account
 * @property string $pwd
 * @property integer $pid
 * @property integer $is_admin
 * @property string $right
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class OperateAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_operate_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'is_admin', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['name', 'account', 'pwd'], 'string', 'max' => 64],
            [['right'], 'string', 'max' => 128],
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
            'account' => 'Account',
            'pwd' => 'Pwd',
            'pid' => 'Pid',
            'is_admin' => 'Is Admin',
            'right' => 'Right',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
