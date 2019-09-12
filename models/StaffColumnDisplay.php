<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_column_display".
 *
 * @property integer $id
 * @property integer $sid
 * @property integer $name
 * @property integer $gender
 * @property integer $date_of_birth
 * @property integer $height
 * @property integer $eye_color
 * @property integer $profession
 * @property integer $blood_type
 * @property integer $team
 * @property integer $special_function
 * @property integer $section
 * @property integer $department
 * @property integer $citizenship
 * @property integer $rank
 * @property integer $security_level
 * @property integer $registered
 * @property integer $resistance_cell
 * @property integer $callsign
 * @property integer $status_alive
 * @property integer $created
 * @property integer $updated
 * @property string $staff_sid
 *
 * @property Staff $staffS
 */
class StaffColumnDisplay extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_column_display';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'name', 'gender', 'date_of_birth', 'height', 'eye_color', 'profession', 'blood_type', 'team', 'special_function', 'section', 'department', 'citizenship', 'rank', 'security_level', 'registered', 'resistance_cell', 'callsign', 'status_alive', 'created', 'updated'], 'integer'],
            [['staff_sid'], 'required'],
            [['staff_sid'], 'string', 'max' => 8],
            [['staff_sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_sid' => 'sid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => 'Sid',
            'name' => 'Name',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'height' => 'Height',
            'eye_color' => 'Eye Color',
            'profession' => 'Profession',
            'blood_type' => 'Blood Type',
            'team' => 'Team',
            'special_function' => 'Special Function',
            'section' => 'Section',
            'department' => 'Department',
            'citizenship' => 'Citizenship',
            'rank' => 'Rank',
            'security_level' => 'Security Level',
            'registered' => 'Registered',
            'resistance_cell' => 'First Registered At',
            'callsign' => 'Callsign',
            'status_alive' => 'Is Alive',
            'created' => 'Created',
            'updated' => 'Updated',
            'staff_sid' => 'Staff Sid',
        ];
    }

    public function getExcludeArray()
    {
        $attributes = $this->getAttributes();
        $exclude = [];
        foreach ($attributes as $attribute => $value) {
            if($attribute == "staff_sid") continue;
            if($value == 0) $exclude[] = $attribute;
        }
        return $exclude;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffS()
    {
        return $this->hasOne(Staff::className(), ['sid' => 'staff_sid']);
    }
}