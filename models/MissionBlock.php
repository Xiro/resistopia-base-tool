<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission_block".
 *
 * @property integer $id
 * @property string $blocked_staff_member_rpn
 * @property string $blocked_by_rpn
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
            [['blocked_staff_member_rpn', 'blocked_by_rpn'], 'required'],
            [['unblock_time', 'created'], 'safe'],
            [['reason'], 'string', 'max' => 250],
            [['blocked_staff_member_rpn', 'blocked_by_rpn'], 'string', 'max' => 8],
            [['blocked_staff_member_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['blocked_staff_member_rpn' => 'rpn']],
            [['blocked_by_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['blocked_by_rpn' => 'rpn']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blocked_staff_member_rpn' => 'Blocked Staff Member',
            'blocked_by_rpn' => 'Blocked By',
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
        return $this->hasOne(Staff::className(), ['rpn' => 'blocked_staff_member_rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockedBy()
    {
        return $this->hasOne(Staff::className(), ['rpn' => 'blocked_by_rpn']);
    }
}
