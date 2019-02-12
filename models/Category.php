<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_category".
 *
 * @property integer $id
 * @property integer $p_id
 * @property string $name
 * @property integer $is_system
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_id', 'is_system', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'p_id' => 'P ID',
            'name' => 'Name',
            'is_system' => 'Is System',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
