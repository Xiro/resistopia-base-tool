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
        $templateStatusId = SelectData::fromModel(
            MissionStatus::class,
            'name',
            'id'
        )['template'];
        return array_merge(parent::rules(), [
            [['staffSelect'], 'safe'],
            [
                ['time_lst', 'time_ete', 'time_atf'],
                'required',
                'when'       => function ($model) use ($templateStatusId) {
                    /** @var $model MissionForm */
                    return $model->mission_status_id != $templateStatusId;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#missionform-mission_status_id').val() != $templateStatusId;
                }"
            ],
            ['time_atf', 'validateDuration'],
        ]);
    }

    public function validateDuration($attribute, $params)
    {
        if (1 !== preg_match('/[0-9]{1,2}:[0-9]{2}/', $this->$attribute)) {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . " must be in format HH:MM");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->mission_lead_rpn = $this->mission_lead_rpn ? $this->mission_lead_rpn : null;

        $this->updateToOne('operation');

        $isSaved = parent::save($runValidation, $attributeNames);
        if (!$isSaved) {
            return false;
        }

        if($this->mission_lead_rpn) {
            $this->staffSelect = $this->staffSelect === false ? [] : $this->staffSelect;
            if(!in_array($this->mission_lead_rpn, $this->staffSelect)) {
                $this->staffSelect[] = $this->mission_lead_rpn;
            }
        }
        if($this->staffSelect !== false) {
            $this->updateToMany("staff", Staff::class, $this->staffSelect, true, 'rpn');
        }

        /** @var MissionStatusHistory $lastStatus */
        $lastStatus = $this->getMissionStatusHistory()->one();
        if ($this->mission_status_id && (!$lastStatus || $lastStatus->mission_status_id != $this->mission_status_id)) {
            $newStatus = new MissionStatusHistory();
            $newStatus->mission_status_id = $this->mission_status_id;
            $newStatus->mission_id = $this->id;
            $newStatus->author_rpn = AccessRule::activeStaff()->rpn;
            if (!$newStatus->save()) {
                return false;
            }
        }

        return $isSaved;
    }

}