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

        $this->updateToMany("staff", Staff::className(), $this->staffSelect);

        return parent::save($runValidation, $attributeNames);
    }

}