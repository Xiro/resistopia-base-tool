<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "blood_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Staff[] $staff
 */
class BloodType extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blood_type';
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
        return $this->hasMany(Staff::className(), ['blood_type_id' => 'id']);
    }
}
