<?php

namespace app\models\form;

use app\models\Mission;
use app\models\MissionStatus;
use app\models\Operation;
use app\models\Staff;
use yii\db\ActiveRecord;

class MissionForm extends Mission
{

    public $staffSelect = [];
    public $operation;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->mission_status_id = MissionStatus::findOne(["name" => MissionStatus::STATUS_PENDING]);
    }

    public function afterFind()
    {
        $this->operation = $this->operation_id ? $this->operation_id : null;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [[
                "staffSelect",
                "operation",
            ], "safe"],
            [[
                'mission_type_id',
                'mission_status_id',
                'operation'
            ], 'required'],
            [['operation'], 'string', 'max' => 50],
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
        if(is_numeric($this->operation) && Operation::find()->where(["id" => $this->operation])->count() > 0) {
            $this->operation_id = $this->operation;
        } elseif(null !== ($operation = Operation::findOne(["name" => $this->operation]))) {
            $this->operation_id = $operation->id;
        } else {
            $addOperation = new Operation();
            $addOperation->name = $this->operation;
            $addOperation->save();
            $this->operation_id = $addOperation->id;
        }

        if($this->isNewRecord || $this->getIsNewRecord()) {
            parent::save($runValidation, $attributeNames);
        }

        $this->updateManyToMany("staff", Staff::className(), $this->staffSelect);
//        $existingStaffIds = array_column($this->getMissionStaff()->asArray()->all(), "staff_id");
//        foreach ($this->staffSelect as $staffId) {
//            if(in_array($staffId, $existingStaffIds)) {
//                continue;
//            }
//            $addMissionStaff = new MissionStaff();
//            $addMissionStaff->mission_id = $this->id;
//            $addMissionStaff->staff_id = $this->id;
//            $addMissionStaff->paid = "No";
//            $addMissionStaff->save();
//        }

        return parent::save($runValidation, $attributeNames);
    }

    protected function updateManyToMany($relationName, $modelClass, $selectedIds)
    {
        $selectedIds = empty($selectedIds) ? array() : $selectedIds;
        /** @var ActiveRecord $modelClass */

        $existing = [];
        foreach ($this->$relationName as $relatedModel) {
            $existing[$relatedModel->id] = $relatedModel;
        }
        $existingIds = array_keys($existing);

        $removeIds = array_diff($existingIds, $selectedIds);
        foreach ($removeIds as $removeId) {
            $this->unlink($relationName, $existing[$removeId], true);
        }

        $addIds = array_diff($selectedIds, $existingIds);
        foreach ($addIds as $addId) {
            $linkModel = $modelClass::findOne($addId);
            if(!$linkModel) {
                throw new \InvalidArgumentException("$modelClass with ID $addId does not exist");
            }
            $this->link($relationName, $linkModel);
        }
    }

}