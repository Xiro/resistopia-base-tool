<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission_staff".
 *
 * @property integer $mission_id
 * @property integer $staff_id
 * @property string $paid
 *
 * @property Mission $mission
 * @property Staff $staff
 */
class MissionStaff extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mission_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mission_id', 'staff_id'], 'required'],
            [['mission_id', 'staff_id'], 'integer'],
            [['paid'], 'string'],
            [['mission_id', 'staff_id'], 'unique', 'targetAttribute' => ['mission_id', 'staff_id'], 'message' => 'The combination of Mission ID and Staff ID has already been taken.'],
            [['mission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mission::className(), 'targetAttribute' => ['mission_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mission_id' => 'Mission ID',
            'staff_id' => 'Staff ID',
            'paid' => 'Paid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMission()
    {
        return $this->hasOne(Mission::className(), ['id' => 'mission_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
}
