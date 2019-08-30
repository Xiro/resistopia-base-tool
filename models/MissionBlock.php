<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission_block".
 *
 * @property integer $id
 * @property string $blocked_staff_member_sid
 * @property string $blocked_by_sid
 * @property string $unblock_time
 * @property string $reason
 * @property string $created
 *
 * @property Staff $blockedStaffMember
 * @property Staff $blockedBy
 */
class MissionBlock extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mission_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blocked_staff_member_sid', 'blocked_by_sid'], 'required'],
            [['unblock_time', 'created'], 'safe'],
            [['reason'], 'string', 'max' => 250],
            [['blocked_staff_member_sid', 'blocked_by_sid'], 'string', 'max' => 8],
            [['blocked_staff_member_sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['blocked_staff_member_sid' => 'sid']],
            [['blocked_by_sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['blocked_by_sid' => 'sid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blocked_staff_member_sid' => 'Blocked Staff Member',
            'blocked_by_sid' => 'Blocked By',
            'unblock_time' => 'Unblock Time',
            'reason' => 'Reason',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockedStaffMember()
    {
        return $this->hasOne(Staff::className(), ['sid' => 'blocked_staff_member_sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockedBy()
    {
        return $this->hasOne(Staff::className(), ['sid' => 'blocked_by_sid']);
    }
}
