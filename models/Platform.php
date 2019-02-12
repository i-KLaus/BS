<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_platform".
 *
 * @property integer $id
 * @property string $platform_name
 * @property integer $platform_type
 * @property integer $status
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class Platform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_platform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_type', 'status', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['platform_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'platform_name' => 'Platform Name',
            'platform_type' => 'Platform Type',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
