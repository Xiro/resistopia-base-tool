<?php

namespace app\models\forms;

use app\models\AccessKey;
use app\models\Staff;
use mate\yii\models\form\UpdateDynamicToOneTrait;

/**
 * StaffForm represents the form for the model `app\models\Staff`.
 */
class StaffForm extends Staff
{

    use UpdateDynamicToOneTrait;

    public $status_alive = true;
    public $status_be13 = true;
    public $status_it = true;
    public $status_in_base = true;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
        ]);
    }

    public function afterFind()
    {
        $this->date_of_birth = date('d.m.Y', strtotime($this->date_of_birth));
    }

    public function createRpn()
    {
        do {
            $rpn = "";
            $rpn .= strtoupper(substr($this->forename, 0, 1));
            $rpn .= strtoupper(substr($this->surname, 0, 1));
            $rpn .= "-";
            $rpn .= rand(10000,99999);
            $alreadyExists = 0 < self::find()->where(["rpn" => $rpn])->count();
        } while($alreadyExists);
        return $rpn;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->updateToOne('team');
        $this->updateToOne('company');
        $this->updateToOne('citizenship');
        $this->date_of_birth = date('Y-m-d', strtotime($this->date_of_birth));

        if($this->getIsNewRecord()) {
            $this->rpn = $this->createRpn();

            $accessKey = new AccessKey();
            $accessKey->access_key = 0;
            $accessKey->save();
            $this->access_key_id = $accessKey->id;
        }

        return parent::save($runValidation, $attributeNames);
    }

}