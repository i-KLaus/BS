<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%merchant}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $alias
 * @property integer $industry
 * @property string $product_type
 * @property string $invoice_info
 * @property string $finance_contact
 * @property string $finance_contact_info
 * @property string $create_time
 * @property string $last_time
 * @property integer $flag
 */
class Merchant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%merchant}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'industry', 'flag'], 'integer'],
            [['create_time', 'last_time'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['invoice_info'], 'string', 'max' => 256],
            [['product_type'], 'string', 'max' => 256],
            [['alias', 'finance_contact'], 'string', 'max' => 64],
            [['finance_contact_info'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'alias' => 'Alias',
            'industry' => 'Industry',
            'product_type' => 'Product Type',
            'invoice_info' => 'Invoice Info',
            'finance_contact' => 'Finance Contact',
            'finance_contact_info' => 'Finance Contact Info',
            'create_time' => 'Create Time',
            'last_time' => 'Last Time',
            'flag' => 'Flag',
        ];
    }
}
