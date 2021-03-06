<?php

namespace app\models\forms;

use app\components\AccessRule;
use app\models\Mission;
use app\models\MissionStatus;
use app\models\MissionStatusHistory;
use app\models\Staff;
use mate\yii\models\form\UpdateDynamicToOneTrait;
use mate\yii\models\form\UpdateToManyTrait;
use mate\yii\widgets\SelectData;

/**
 * MissionForm represents the form for the model `app\models\Mission`.
 */
class MissionForm extends Mission
{

    use UpdateDynamicToOneTrait;
    use UpdateToManyTrait;

    /**
     * @var bool|array
     */
    public $staffSelect = false;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        if ($this->isNewRecord) {
            $this->mission_status_id = SelectData::fromModel(
                MissionStatus::class,
                'name',
                'id'
            )['planing'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        $this->time_atf = $this->time_atf ? date('H:i', strtotime($this->time_atf)) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $statusIds = SelectData::fromModel(
            MissionStatus::class,
            'name',
            'id'
        );
        return array_merge(parent::rules(), [
            [['staffSelect'], 'safe'],
            [
//                ['time_lst', 'time_ete', 'time_atf'],
                ['troop_strength', 'troop_name'],
                'required',
                'when'       => function ($model) use ($statusIds) {
                    /** @var $model MissionForm */
                    return !in_array($model->mission_status_id, [
                        $statusIds['template'],
                        $statusIds['OT'],
                        $statusIds['planing'],
                    ]);
                },
                'whenClient' => "function (attribute, value) {
                    var val = $('#missionform-mission_status_id').val();
                    return (val != {$statusIds['template']} && val != {$statusIds['OT']} && val != {$statusIds['planing']});
                }"
            ],
//            ['time_atf', 'validateDuration'],
//            ['mission_lead_sid', 'validateUniqueMissionLead'],
        ]);
    }

    public function validateDuration($attribute, $params)
    {
        if (1 !== preg_match('/[0-9]{1,2}:[0-9]{2}/', $this->$attribute)) {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . " must be in format HH:MM");
        }
    }

//    public function validateUniqueMissionLead($attribute, $params)
//    {
//        $statusIds = MissionStatus::getStatusIds();
//        $lockStatusIds = [
//            $statusIds['planing'],
//            $statusIds['openLeadercall'],
//            $statusIds['openCrewcall'],
//            $statusIds['ready'],
//            $statusIds['active'],
//            $statusIds['back'],
//        ];
//        $otherLeadMissionsQuery = Mission::find()
//            ->where(['mission_status_id' => $lockStatusIds])
//            ->andWhere(['mission_lead_sid' => $this->$attribute]);
//        if($this->id) {
//            $otherLeadMissionsQuery->andWhere(['!=', 'id', $this->id]);
//        }
//        if (in_array($this->mission_status_id, $lockStatusIds) && $otherLeadMissionsQuery->count() > 0) {
//            $missions = $otherLeadMissionsQuery->asArray()->all();
//            $missionNames = array_column($missions, 'name');
//            $this->addError($attribute, "Mission Lead already assigned to another mission (". implode(', ', $missionNames) .")");
//        }
//    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->mission_lead_sid = $this->mission_lead_sid ? $this->mission_lead_sid : null;

        $this->updateToOne('operation');

        $isSaved = parent::save($runValidation, $attributeNames);
        if (!$isSaved) {
            return false;
        }

        if ($this->mission_lead_sid) {
            $this->staffSelect = $this->staffSelect === false ? [] : $this->staffSelect;
            if (!in_array($this->mission_lead_sid, $this->staffSelect)) {
                $this->staffSelect[] = $this->mission_lead_sid;
            }
        }
        if ($this->staffSelect !== false) {
            $this->updateToMany("staff", Staff::class, $this->staffSelect, true, 'sid');
        }

        /** @var MissionStatusHistory $lastStatus */
        $lastStatus = $this->getMissionStatusHistory()->one();
        if ($this->mission_status_id && (!$lastStatus || $lastStatus->mission_status_id != $this->mission_status_id)) {
            $newStatus = new MissionStatusHistory();
            $newStatus->mission_status_id = $this->mission_status_id;
            $newStatus->mission_id = $this->id;
            $newStatus->author_sid = AccessRule::activeStaff()->sid;
            if (!$newStatus->save()) {
                return false;
            }
        }

        return $isSaved;
    }

}