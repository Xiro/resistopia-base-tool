<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "access".
 *
 * @property integer $id
 * @property string $name
 *
 * @property StaffAccess[] $staffAccesses
 * @property Staff[] $staff
 */
class Access extends ActiveRecord
{
    const ACCESS_MISSION = "Mission";
    const ACCESS_STAFF = "Staff";
    const ACCESS_MEDICINE = "Medicine";
    const ACCESS_SECURITY = "Security";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffAccesses()
    {
        return $this->hasMany(StaffAccess::className(), ['access_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['id' => 'staff_id'])->viaTable('staff_access', ['access_id' => 'id']);
    }
}
