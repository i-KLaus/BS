<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yx_statistice_visit".
 *
 * @property integer $id
 * @property string $date
 * @property integer $visit_num
 * @property string $create_time
 * @property string $last_time
 */
class StatisticeVisit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_statistice_visit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date', 'create_time', 'last_time'], 'safe'],
            [['visit_num'], 'integer'],
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
            'visit_num' => 'Visit Num',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
        ];
    }
}
