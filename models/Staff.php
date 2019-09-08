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
 * @property integer $status_alive
 * @property integer $status_in_base
 * @property integer $squat_number
 * @property integer $access_key_id
 * @property integer $rank_id
 * @property integer $resistance_cell_id
 * @property integer $section_id
 * @property integer $special_function_id
 * @property integer $citizenship_id
 * @property integer $eye_color_id
 * @property integer $team_id
 * @property integer $blood_type_id
 * @property string $registered IT registration date
 * @property string $created
 * @property string $updated
 * @property bool $isBlocked
 * @property string $name
 * @property string $nameWithSid
 * @property string $fullSID
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
 * @property Section $section
 * @property BloodType $bloodType
 * @property Citizenship $citizenship
 * @property EyeColor $eyeColor
 * @property Rank $rank
 * @property ResistanceCell $resistanceCell
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
            [['sid', 'forename', 'surname', 'gender', 'date_of_birth', 'access_key_id', 'section_id', 'resistance_cell_id', 'registered'], 'required'],
            [['gender'], 'string'],
            [['date_of_birth', 'registered', 'created', 'updated'], 'safe'],
            [['height', 'status_alive', 'status_in_base', 'squat_number', 'access_key_id', 'rank_id', 'section_id', 'special_function_id', 'eye_color_id', 'blood_type_id'], 'integer'],
            [['sid'], 'string', 'max' => 8],
            [['forename', 'surname', 'nickname', 'profession'], 'string', 'max' => 128],
            [['callsign'], 'string', 'max' => 5],
            [['sid'], 'unique'],
            [['callsign'], 'unique'],
            [['access_key_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessKey::class, 'targetAttribute' => ['access_key_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::class, 'targetAttribute' => ['section_id' => 'id']],
            [['blood_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BloodType::class, 'targetAttribute' => ['blood_type_id' => 'id']],
            [['citizenship_id'], 'exist', 'skipOnError' => true, 'targetClass' => Citizenship::class, 'targetAttribute' => ['citizenship_id' => 'id']],
            [['eye_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => EyeColor::class, 'targetAttribute' => ['eye_color_id' => 'id']],
            [['rank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rank::class, 'targetAttribute' => ['rank_id' => 'id']],
            [['resistance_cell_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResistanceCell::class, 'targetAttribute' => ['resistance_cell_id' => 'id']],
            [['special_function_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpecialFunction::class, 'targetAttribute' => ['special_function_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::class, 'targetAttribute' => ['team_id' => 'id']],
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
            'status_alive' => 'Status Alive',
            'status_in_base' => 'Status In Base',
            'squat_number' => 'Squat Number',
            'access_key_id' => 'Access Key',
            'rank_id' => 'Rank',
            'resistance_cell_id' => 'Resistance Cell',
            'section_id' => 'Section',
            'special_function_id' => 'Special Function',
            'citizenship_id' => 'Citizenship',
            'eye_color_id' => 'Eye Color',
            'team_id' => 'Team',
            'blood_type_id' => 'Blood Type',
            'registered' => 'Registered',
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
     * @property Section $section
     * @property Citizenship $citizenship
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

        if($this->access_key_id) {
            $this->accessKey->delete();
        }

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

    public function getFullSID()
    {
        $cell = $this->resistanceCell;
        if(!$cell || !$this->registered) {
            return null;
        }
        $parts = [];
        $parts[] = ($cell->latitude > 0 ? 1 : 0) . sprintf('%05d',round($cell->latitude, 2) * 100);
        $parts[] = ($cell->longitude > 0 ? 1 : 0) . sprintf('%05d',round($cell->longitude, 2) * 100);
        $parts[] = sprintf('%04d', round((strtotime($this->registered) - strtotime("2022-01-03")) / 60 / 60 / 24));
        $parts[] = $this->sid;
        return implode(".", $parts);
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
        return $this->hasMany(Mission::class, ['mission_lead_sid' => 'sid']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediFoamDistributions()
    {
        return $this->hasMany(MediFoamDistribution::class, ['recipient_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineCheckups()
    {
        return $this->hasMany(MedicineCheckup::class, ['patient_sid' => 'sid']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineTreatments()
    {
        return $this->hasMany(MedicineTreatment::class, ['patient_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionBlocks()
    {
        return $this->hasMany(MissionBlock::class, ['blocked_staff_member_sid' => 'sid']);
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
        return $this->hasMany(MissionStaff::class, ['staff_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissions()
    {
        return $this->hasMany(Mission::class, ['id' => 'mission_id'])->viaTable('mission_staff', ['staff_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBloodType()
    {
        return $this->hasOne(BloodType::class, ['id' => 'blood_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionStatusHistories()
    {
        return $this->hasMany(MissionStatusHistory::class, ['author_sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessKey()
    {
        return $this->hasOne(AccessKey::class, ['id' => 'access_key_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitizenship()
    {
        return $this->hasOne(Citizenship::class, ['id' => 'citizenship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEyeColor()
    {
        return $this->hasOne(EyeColor::class, ['id' => 'eye_color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRank()
    {
        return $this->hasOne(Rank::class, ['id' => 'rank_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResistanceCell()
    {
        return $this->hasOne(ResistanceCell::class, ['id' => 'resistance_cell_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialFunction()
    {
        return $this->hasOne(SpecialFunction::class, ['id' => 'special_function_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffBackground()
    {
        return $this->hasOne(StaffBackground::class, ['sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffFileMemos()
    {
        return $this->hasMany(StaffFileMemo::class, ['sid' => 'sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['sid' => 'sid']);
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
