<?php

namespace app\models\form;

use app\models\Mission;
use app\models\MissionStatus;
use app\models\Operation;
use app\models\Staff;
use app\models\Team;
use yii\db\ActiveRecord;

class TeamForm extends Team implements StaffSelectFormInterface
{

    use UpdateToManyTrait;

    public $staffSelect = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [[
                "staffSelect",
            ], "safe"],
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
        if($this->isNewRecord || $this->getIsNewRecord()) {
            parent::save($runValidation, $attributeNames);
        }

        $this->updateToMany("staff", Staff::className(), $this->staffSelect);

        return parent::save($runValidation, $attributeNames);
    }

}