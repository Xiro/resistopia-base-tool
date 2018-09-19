<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ticker".
 *
 * @property integer $id
 * @property string $message
 * @property integer $active
 * @property integer $order
 * @property string $created
 */
class Ticker extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['active', 'order'], 'integer'],
            [['created'], 'safe'],
            [['message'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'active' => 'Active',
            'order' => 'Order',
            'created' => 'Created',
        ];
    }
}
