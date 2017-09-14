<?php

namespace app\models\form;

use app\models\MissionCall;
use app\models\Operation;

class MissionCallForm extends MissionCall
{

    use UpdateToManyTrait;

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if(!is_numeric($this->operation_id) && null !== ($operation = Operation::findOne(["name" => $this->operation_id]))) {
            $this->operation_id = $operation->id;
        } elseif(!empty($this->operation_id)) {
            $addOperation = new Operation();
            $addOperation->name = $this->operation_id;
            $addOperation->save();
            $this->operation_id = $addOperation->id;
        }

        return parent::save($runValidation, $attributeNames);
    }

}