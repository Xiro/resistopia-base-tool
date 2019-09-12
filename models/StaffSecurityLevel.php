<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_security_level".
 *
 * @property string $sid
 * @property string security_level
 */
class StaffSecurityLevel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_security_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid'], 'string', 'max' => 8],
            [['security_level'], 'string', 'max' => 135],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'Sid',
            'security_level' => 'Security Level',
        ];
    }
}
