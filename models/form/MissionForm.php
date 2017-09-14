<?php

namespace app\models\form;

use app\models\Mission;
use app\models\MissionStatus;
use app\models\Operation;
use app\models\Staff;
use yii\db\ActiveRecord;

class MissionForm extends Mission implements StaffSelectFormInterface
{

    use UpdateToManyTrait;

    public $staffSelect = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->mission_status_id = MissionStatus::findOne(["name" => MissionStatus::STATUS_PENDING]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [[
                "staffSelect",
            ], "safe"],
            [[
                'mission_type_id',
                'mission_status_id',
            ], 'required'],
        ]);
    }

    public function getCombinedStaffModels()
    {
        $combinedStaff = [];
        foreach ($this->staff as $staff) {
            $combinedStaff[$staff->id] = $staff;
        }
        foreach ($this->staffSelect as $staffId) {
            $combinedStaff[$staffId] = Staff::findOne($staffId);
        }
        return $combinedStaff;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if(!is_numeric($this->operation_id) && null !== ($operation = Operation::findOne(["name" => $this->operation_id]))) {
            $this->operation_id = $operation->id;
        } elseif(!is_numeric($this->operation_id) && !empty($this->operation_id)) {
            $addOperation = new Operation();
            $addOperation->name = $this->operation_id;
            $addOperation->save();
            $this->operation_id = $addOperation->id;
        }

        if($this->getIsNewRecord()) {
            $isSaved = parent::save($runValidation, $attributeNames);
            if(!$isSaved) {
                return false;
            }
        }

        $this->updateToMany("staff", Staff::className(), $this->staffSelect);

        return parent::save($runValidation, $attributeNames);
    }

}