<?php

namespace app\models;

use app\models\behaviors\ChangeLogBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff".
 *
 * @property string $sid
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
 * @property integer $blood_type_id
 * @property string $created
 * @property string $updated
 * @property bool $isBlocked
 * @property string $name
 * @property string $nameWithSid
 * @property integer $currentMediFoam
 * @property integer $securityLevel
 *
 * @property MediFoamDistribution[] $mediFoamDistributions
 * @property MedicineCheckup[] $medicineCheckups
 * @property MedicineTreatment[] $medicineTreatments
 * @property Mission[] $missions
 * @property Mission[] $missionLeads
 * @property MissionBlock[] $missionBlocks
 * @property MissionBlock[] $activeMissionBlocks
 * @property MissionStaff[] $missionStaff
 * @property Mission[] $missions1
 * @property MissionStatusHistory[] $missionStatusHistories
 * @property AccessKey $accessKey
 * @property BaseCategory $baseCategory
 * @property BloodType $bloodType
 * @property Citizenship $citizenship
 * @property Company $company
 * @property EyeColor $eyeColor
 * @property Rank $rank
 * @property SpecialFunction $specialFunction
 * @property Team $team
 * @property StaffBackground $staffBackground
 * @property StaffFileMemo[] $staffFileMemos
 * @property User $user
 * @property Changelog[] $changes
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
            [['sid', 'forename', 'surname', 'gender', 'date_of_birth', 'access_key_id', 'rank_id'], 'required'],
            [['gender'], 'string'],
            [['date_of_birth', 'created', 'updated'], 'safe'],
            [['height', 'status_it', 'status_be13', 'status_alive', 'status_in_base', 'squat_number', 'access_key_id', 'rank_id', 'base_category_id', 'special_function_id', 'eye_color_id', 'blood_type_id'], 'integer'],
            [['sid'], 'string', 'max' => 8],
            [['forename', 'surname', 'nickname', 'profession'], 'string', 'max' => 128],
            [['callsign'], 'string', 'max' => 5],
            [['sid'], 'unique'],
            [['callsign'], 'unique'],
            [['access_key_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessKey::className(), 'targetAttribute' => ['access_key_id' => 'id']],
            [['base_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseCategory::className(), 'targetAttribute' => ['base_category_id' => 'id']],
            [['blood_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BloodType::className(), 'targetAttribute' => ['blood_type_id' => 'id']],
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
            'sid' => 'SID',
            'forename' => 'Forename',
            'surname' => 'Surname',
            'nickname' => 'Nickname',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'profession' => 'Profession',
            'callsign' => 'Callsign',
            'height' => 'Height (cm)',
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
            'blood_type_id' => 'Blood Type',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'              => ChangeLogBehavior::class,
                'excludedAttributes' => [
                    'updated',
                    'status_in_base'
                ],
            ],
        ];
    }

    /**
     * @return false|int|void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     *
     * @property Mission[] $missions
     * @property Mission[] $missionLeads
     * @property MissionBlock[] $missionBlocks
     * @property MissionBlock[] $activeMissionBlocks
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
     * @property User[] $users
     */
    public function delete()
    {
        foreach ($this->missions as $mission) {
            $this->unlink('missions', $mission, true);
        }
        foreach ($this->missionLeads as $missionLead) {
            $missionLead->unlink('missionLead', $this);
        }
        foreach ($this->missionBlocks as $missionBlock) {
            $missionBlock->delete();
        }
        foreach ($this->missionStatusHistories as $missionStatusHistory) {
            $missionStatusHistory->unlink('author', $this);
        }
        if($this->user) {
            $this->user->delete();
        }
        if($this->staffBackground) {
            $this->staffBackground->delete();
        }
        foreach ($this->staffFileMemos as $staffFileMemo) {
            $staffFileMemo->delete();
        }

        $this->accessKey->delete();

        parent::delete();
    }

    public function beforeSave($insert)
    {
        if(empty($this->callsign)) {
            $this->callsign = null;
        }
        return parent::beforeSave($insert);
    }

    public function getIsBlocked()
    {
        return 0 != $this->getActiveMissionBlocks()->count();
    }

    public function getName()
    {
        return $this->forename . ' ' . ($this->nickname ? '"' . $this->nickname . '" ' : '') . $this->surname;
    }

    public function getNameWithSid()
    {
        return $this->name . ' (' . $this->sid . ')';
    }

    public function getCurrentMediFoam()
    {
        $mediFoam = MediFoamDistribution::find()
            ->select('SUM(mk1_issued) - SUM(mk1_returned) as medi_foam_current')
            ->where(['recipient_sid' => $this->sid])
            ->asArray()
            ->one();
        return $mediFoam ? $mediFoam['medi_foam_current'] : 0;
    }

    public function getSecurityLevel()
    {
        $accessList = AccessKey::findAccessList($this->access_key_id);
        $accessList = array_flip($accessList);
        $securityLevel = 0;
        foreach ($accessList as $accessKey) {
            if('security-level/' != substr($accessKey, 0, 15)) {
                continue;
            }
            $foundLevel = (int) substr($accessKey, 15);
            if($foundLevel > $securityLevel) {
                $securityLevel = $foundLevel;
            }
        }
        return $securityLevel;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionLeads()
    {
        return $this->hasMany(Mission::className(), ['mission_lead_sid' => 'sid']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediFoamDistributions()
    {
        return $this->hasMany(MediFoamDistribution::className(), ['recipient_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineCheckups()
    {
        return $this->hasMany(MedicineCheckup::className(), ['patient_sid' => 'sid']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineTreatments()
    {
        return $this->hasMany(MedicineTreatment::className(), ['patient_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionBlocks()
    {
        return $this->hasMany(MissionBlock::className(), ['blocked_staff_member_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveMissionBlocks()
    {
        return $this->getMissionBlocks()->where([
            'or',
            ['>=', 'unblock_time', date('c')],
            ['unblock_time' => null]
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionStaff()
    {
        return $this->hasMany(MissionStaff::className(), ['staff_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissions()
    {
        return $this->hasMany(Mission::className(), ['id' => 'mission_id'])->viaTable('mission_staff', ['staff_sid' => 'sid']);
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
    public function getMissionStatusHistories()
    {
        return $this->hasMany(MissionStatusHistory::className(), ['author_sid' => 'sid']);
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
        return $this->hasOne(StaffBackground::className(), ['sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffFileMemos()
    {
        return $this->hasMany(StaffFileMemo::className(), ['sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChanges()
    {
        return Changelog::find()->where([
            'object' => 'Staff',
            'primary_key' => $this->sid
        ])->orderBy('created DESC');
    }
}
