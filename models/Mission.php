<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $debrief_comment
 * @property string $note
 * @property string $zone
 * @property integer $slots_total
 * @property integer $slots_medic
 * @property integer $slots_radio
 * @property integer $slots_tech
 * @property integer $slots_res
 * @property integer $slots_guard
 * @property integer $slots_vip
 * @property integer $mission_status_id
 * @property integer $operation_id
 * @property integer $mission_type_id
 * @property string $created_by_rpn
 * @property string $mission_lead_rpn
 * @property string $time_publish
 * @property string $time_lst
 * @property string $time_ete
 * @property string $time_atf
 * @property array $callsigns
 * @property string $finished
 * @property string $created
 * @property string $updated
 *
 * @property MissionStatus $missionStatus
 * @property MissionType $missionType
 * @property Operation $operation
 * @property Staff $createdBy
 * @property Staff $missionLead
 * @property Staff[] $staff
 * @property MissionStatusHistory[] $missionStatusHistory
 */
class Mission extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zone', 'mission_type_id', 'created_by_rpn'], 'required'],
            [['description', 'debrief_comment', 'note', 'zone'], 'string'],
            [['slots_total', 'slots_medic', 'slots_radio', 'slots_tech', 'slots_res', 'slots_guard', 'slots_vip', 'mission_status_id', 'mission_type_id'], 'integer'],
            [['time_publish', 'time_lst', 'time_ete', 'time_atf', 'finished', 'created', 'updated'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['created_by_rpn', 'mission_lead_rpn'], 'string', 'max' => 8],
            [['mission_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => MissionStatus::class, 'targetAttribute' => ['mission_status_id' => 'id']],
            [['mission_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MissionType::class, 'targetAttribute' => ['mission_type_id' => 'id']],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::class, 'targetAttribute' => ['operation_id' => 'id']],
            [['created_by_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::class, 'targetAttribute' => ['created_by_rpn' => 'rpn']],
            [['mission_lead_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::class, 'targetAttribute' => ['mission_lead_rpn' => 'rpn']],
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
            'description' => 'Description',
            'debrief_comment' => 'Debrief Comment',
            'note' => 'Note',
            'zone' => 'Zone',
            'slots_total' => 'Slots Total',
            'slots_medic' => 'Slots Medic',
            'slots_radio' => 'Slots Radio',
            'slots_tech' => 'Slots Tech',
            'slots_res' => 'Slots Res',
            'slots_guard' => 'Slots Guard',
            'slots_vip' => 'Slots VIP',
            'mission_status_id' => 'Mission Status',
            'operation_id' => 'Operation',
            'mission_type_id' => 'Type',
            'created_by_rpn' => 'Created By',
            'mission_lead_rpn' => 'Mission Lead',
            'time_publish' => 'Time Publish',
            'time_lst' => 'LST',
            'time_ete' => 'ETE',
            'time_atf' => 'ATF',
            'finished' => 'Finished',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function delete()
    {
        foreach ($this->missionStatusHistory as $statusHistory) {
            $statusHistory->delete();
        }
        foreach ($this->staff as $staff) {
            $this->unlink('staff', $staff, true);
        }
        parent::delete();
    }

    public function getCallsigns()
    {
        return array_column(
            $this->getStaff()->where(['!=', 'callsign', ['', null]])->asArray()->all(),
            'callsign'
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionStatus()
    {
        return $this->hasOne(MissionStatus::class, ['id' => 'mission_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionType()
    {
        return $this->hasOne(MissionType::class, ['id' => 'mission_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::class, ['id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Staff::class, ['rpn' => 'created_by_rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionLead()
    {
        return $this->hasOne(Staff::class, ['rpn' => 'mission_lead_rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::class, ['rpn' => 'staff_rpn'])->viaTable('mission_staff', ['mission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionStatusHistory()
    {
        return $this->hasMany(MissionStatusHistory::class, ['mission_id' => 'id'])
            ->orderBy('mission_status_history.created DESC');
    }
}
