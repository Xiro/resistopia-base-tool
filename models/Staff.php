<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff".
 *
 * @property string $rpn
 * @property string $forename
 * @property string $surname
 * @property string $nickname
 * @property string $gender
 * @property string $date_of_birth
 * @property string $profession
 * @property string $callsign
 * @property integer $height
 * @property integer $status_it
 * @property integer $status_be13
 * @property integer $status_alive
 * @property integer $status_in_base
 * @property integer $squat_number
 * @property integer $access_key_id
 * @property integer $rank_id
 * @property integer $base_category_id
 * @property integer $special_function_id
 * @property integer $company_id
 * @property integer $citizenship_id
 * @property integer $eye_color_id
 * @property integer $team_id
 * @property string $created
 * @property string $updated
 *
 * @property Mission[] $missions
 * @property Mission[] $missions0
 * @property MissionBlock[] $missionBlocks
 * @property MissionBlock[] $missionBlocks0
 * @property MissionStaff[] $missionStaff
 * @property Mission[] $missions1
 * @property MissionStatusHistory[] $missionStatusHistories
 * @property AccessKey $accessKey
 * @property BaseCategory $baseCategory
 * @property Citizenship $citizenship
 * @property Company $company
 * @property EyeColor $eyeColor
 * @property Rank $rank
 * @property SpecialFunction $specialFunction
 * @property Team $team
 * @property StaffBackground $staffBackground
 * @property StaffFileMemo[] $staffFileMemos
 * @property StaffFileMemo[] $staffFileMemos0
 * @property User[] $users
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
            [['rpn', 'forename', 'surname', 'gender', 'date_of_birth', 'access_key_id', 'rank_id'], 'required'],
            [['gender'], 'string'],
            [['date_of_birth', 'created', 'updated'], 'safe'],
            [['height', 'status_it', 'status_be13', 'status_alive', 'status_in_base', 'squat_number', 'access_key_id', 'rank_id', 'base_category_id', 'special_function_id', 'eye_color_id'], 'integer'],
            [['rpn'], 'string', 'max' => 8],
            [['forename', 'surname', 'nickname', 'profession', 'callsign'], 'string', 'max' => 128],
            [['rpn'], 'unique'],
            [['access_key_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessKey::className(), 'targetAttribute' => ['access_key_id' => 'id']],
            [['base_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseCategory::className(), 'targetAttribute' => ['base_category_id' => 'id']],
            [['citizenship_id'], 'exist', 'skipOnError' => true, 'targetClass' => Citizenship::className(), 'targetAttribute' => ['citizenship_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['eye_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => EyeColor::className(), 'targetAttribute' => ['eye_color_id' => 'id']],
            [['rank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rank::className(), 'targetAttribute' => ['rank_id' => 'id']],
            [['special_function_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpecialFunction::className(), 'targetAttribute' => ['special_function_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rpn' => 'RPN',
            'forename' => 'Forename',
            'surname' => 'Surname',
            'nickname' => 'Nickname',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'profession' => 'Profession',
            'callsign' => 'Callsign',
            'height' => 'Height',
            'status_it' => 'Status IT',
            'status_be13' => 'Status BE13',
            'status_alive' => 'Status Alive',
            'status_in_base' => 'Status In Base',
            'squat_number' => 'Squat Number',
            'access_key_id' => 'Access Key',
            'rank_id' => 'Rank',
            'base_category_id' => 'Base Category',
            'special_function_id' => 'Special Function',
            'company_id' => 'Company',
            'citizenship_id' => 'Citizenship',
            'eye_color_id' => 'Eye Color',
            'team_id' => 'Team',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function getName()
    {
        return $this->forename . ' ' . ($this->nickname ? '"' . $this->nickname . '" ' : '') . $this->surname;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissions()
    {
        return $this->hasMany(Mission::className(), ['created_by' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissions0()
    {
        return $this->hasMany(Mission::className(), ['mission_lead_rpn' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionBlocks()
    {
        return $this->hasMany(MissionBlock::className(), ['blocked_staff_member' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionBlocks0()
    {
        return $this->hasMany(MissionBlock::className(), ['blocked_by' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionStaff()
    {
        return $this->hasMany(MissionStaff::className(), ['staff_rpn' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissions1()
    {
        return $this->hasMany(Mission::className(), ['id' => 'mission_id'])->viaTable('mission_staff', ['staff_rpn' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionStatusHistories()
    {
        return $this->hasMany(MissionStatusHistory::className(), ['author_rpn' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessKey()
    {
        return $this->hasOne(AccessKey::className(), ['id' => 'access_key_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseCategory()
    {
        return $this->hasOne(BaseCategory::className(), ['id' => 'base_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitizenship()
    {
        return $this->hasOne(Citizenship::className(), ['id' => 'citizenship_id']);
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
    public function getSpecialFunction()
    {
        return $this->hasOne(SpecialFunction::className(), ['id' => 'special_function_id']);
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
    public function getStaffBackground()
    {
        return $this->hasOne(StaffBackground::className(), ['rpn' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffFileMemos()
    {
        return $this->hasMany(StaffFileMemo::className(), ['rpn' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffFileMemos0()
    {
        return $this->hasMany(StaffFileMemo::className(), ['author_rpn' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['rpn' => 'rpn']);
    }
}
