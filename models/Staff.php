<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property string $rpn
 * @property string $forename
 * @property string $surname
 * @property string $nickname
 * @property integer $height
 * @property string $profession
 * @property string $password
 * @property string $created
 * @property string $updated
 * @property string $died
 * @property string $call_sign
 * @property string $is_blocked
 * @property string $is_it
 * @property integer $company_id
 * @property integer $category_id
 * @property integer $speciality_id
 * @property integer $rank_id
 * @property integer $team_id
 * @property integer $blood_type_id
 * @property integer $eye_color_id
 * @property integer $staff_status_id
 *
 * @property BloodType $bloodType
 * @property Category $category
 * @property Company $company
 * @property EyeColor $eyeColor
 * @property Rank $rank
 * @property Speciality $speciality
 * @property StaffStatus $staffStatus
 * @property Team $team
 * @property StaffRole[] $staffRoles
 * @property Role[] $roles
 */
class Staff extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rpn', 'forename', 'rank_id', 'staff_status_id'], 'required'],
            [['height', 'company_id', 'category_id', 'speciality_id', 'rank_id', 'team_id', 'blood_type_id', 'eye_color_id', 'staff_status_id'], 'integer'],
            [['created', 'updated', 'died'], 'safe'],
            [['is_blocked', 'is_it'], 'string'],
            [['rpn'], 'string', 'max' => 10],
            [['forename', 'surname', 'nickname', 'profession', 'password'], 'string', 'max' => 50],
            [['call_sign'], 'string', 'max' => 4],
            [['rpn'], 'unique'],
            [['call_sign'], 'unique'],
            [['blood_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BloodType::className(), 'targetAttribute' => ['blood_type_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['eye_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => EyeColor::className(), 'targetAttribute' => ['eye_color_id' => 'id']],
            [['rank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rank::className(), 'targetAttribute' => ['rank_id' => 'id']],
            [['speciality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speciality::className(), 'targetAttribute' => ['speciality_id' => 'id']],
            [['staff_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffStatus::className(), 'targetAttribute' => ['staff_status_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rpn' => 'Rpn',
            'forename' => 'Forename',
            'surname' => 'Surname',
            'nickname' => 'Nickname',
            'height' => 'Height',
            'profession' => 'Profession',
            'password' => 'Password',
            'created' => 'Created',
            'updated' => 'Updated',
            'died' => 'Died',
            'call_sign' => 'Call Sign',
            'is_blocked' => 'Is Blocked',
            'is_it' => 'Is It',
            'company_id' => 'Company',
            'category_id' => 'Category',
            'speciality_id' => 'Speciality',
            'rank_id' => 'Rank',
            'team_id' => 'Team',
            'blood_type_id' => 'Blood Type',
            'eye_color_id' => 'Eye Color',
            'staff_status_id' => 'Staff Status',
        ];
    }

    public function getName()
    {
        return $this->forename .
            ($this->nickname ? ' "' . $this->nickname . '"' : "") .
            ($this->surname ? ' "' . $this->surname . '"' : "");
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBloodType()
    {
        return $this->hasOne(BloodType::className(), ['id' => 'blood_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEyeColor()
    {
        return $this->hasOne(EyeColor::className(), ['id' => 'eye_color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRank()
    {
        return $this->hasOne(Rank::className(), ['id' => 'rank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeciality()
    {
        return $this->hasOne(Speciality::className(), ['id' => 'speciality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffStatus()
    {
        return $this->hasOne(StaffStatus::className(), ['id' => 'staff_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffRoles()
    {
        return $this->hasMany(StaffRole::className(), ['staff_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['id' => 'role_id'])->viaTable('staff_role', ['staff_id' => 'id']);
    }

    /**
     * @param string $roleName
     * @return \yii\db\ActiveQuery
     */
    public function hasRole($roleName)
    {
        $roles = array_column($this->getRoles()->asArray()->all(), "name");
        return in_array($roleName, $roles);
    }
}