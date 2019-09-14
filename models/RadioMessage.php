<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "radio_message".
 *
 * @property integer $id
 * @property string $callsign
 * @property string $message
 * @property string $created
 */
class RadioMessage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'radio_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['callsign', 'message'], 'required'],
            [['created'], 'safe'],
            [['callsign'], 'string', 'max' => 5],
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
            'callsign' => 'Callsign',
            'message' => 'Message',
            'created' => 'Created',
        ];
    }
}
