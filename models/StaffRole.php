<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_role".
 *
 * @property integer $staff_id
 * @property integer $role_id
 *
 * @property Role $role
 * @property Staff $staff
 */
class StaffRole extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id', 'role_id'], 'required'],
            [['staff_id', 'role_id'], 'integer'],
            [['staff_id', 'role_id'], 'unique', 'targetAttribute' => ['staff_id', 'role_id'], 'message' => 'The combination of Staff ID and Role ID has already been taken.'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
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
            'role_id' => 'Role ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
}
