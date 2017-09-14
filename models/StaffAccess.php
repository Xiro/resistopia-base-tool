<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_access".
 *
 * @property integer $staff_id
 * @property integer $access_id
 *
 * @property Access $access
 * @property Staff $staff
 */
class StaffAccess extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id', 'access_id'], 'required'],
            [['staff_id', 'access_id'], 'integer'],
            [['staff_id', 'access_id'], 'unique', 'targetAttribute' => ['staff_id', 'access_id'], 'message' => 'The combination of Staff ID and Access ID has already been taken.'],
            [['access_id'], 'exist', 'skipOnError' => true, 'targetClass' => Access::className(), 'targetAttribute' => ['access_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => 'Staff ID',
            'access_id' => 'Access ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccess()
    {
        return $this->hasOne(Access::className(), ['id' => 'access_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
}
