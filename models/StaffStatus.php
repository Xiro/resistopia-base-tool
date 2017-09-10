<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_status".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Staff[] $staff
 */
class StaffStatus extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
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
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['staff_status_id' => 'id']);
    }
}
