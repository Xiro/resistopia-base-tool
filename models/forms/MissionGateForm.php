<?php

namespace app\models\forms;

use app\models\Mission;
use app\models\Staff;
use mate\yii\models\form\UpdateToManyTrait;
use yii\helpers\ArrayHelper;

class MissionGateForm extends Mission
{
    use UpdateToManyTrait;

    public $staffAssign = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['staffAssign'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $isSaved = parent::save($runValidation, $attributeNames);
        if(!$isSaved) {
            return false;
        }
        $missionStaff = $this->getStaff()->all();
        $missionStaff = array_combine(ArrayHelper::getColumn($missionStaff, 'sid'), $missionStaff);

        $onMissionSids = array_flip($this->staffAssign);
        $inBase = array_diff_key($missionStaff, $onMissionSids);
        $onMission = array_intersect_key($missionStaff, $onMissionSids);

        $errors = [];
        /** @var Staff $staff */
        foreach ($inBase as $staff) {
            if($staff->status_in_base == 1) {
                continue;
            }
            $staff->status_in_base = 1;
            if(!$staff->save()) $errors[] = $staff->errors;
        }
        foreach ($onMission as $staff) {
            if($staff->status_in_base == 0) {
                continue;
            }
            $staff->status_in_base = 0;
            if(!$staff->save()) $errors[] = $staff->errors;
        }
        if(count($errors)) {
            $this->addError('staffAssign', count($errors) . ' errors');
        }
//        echo '<pre>';
//        echo print_r([
//            $onMissionSids,
//            array_keys($missionStaff),
//            'In Base',
//            array_keys($inBase),
//            'On Mission',
//            array_keys($onMission),
//            $errors
//        ]);
//        echo '</pre>';

        return count($errors) > 0 ? false : $isSaved;
    }
}