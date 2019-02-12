<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property integer $id
 * @property string $area_code
 * @property string $area_parent_id
 * @property string $area_name
 * @property integer $area_type
 * @property string $create_time
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_type'], 'integer'],
            [['create_time'], 'safe'],
            [['area_code', 'area_parent_id'], 'string', 'max' => 11],
            [['area_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area_code' => 'Area Code',
            'area_parent_id' => 'Area Parent ID',
            'area_name' => 'Area Name',
            'area_type' => 'Area Type',
            'create_time' => 'Create Time',
        ];
    }
}
