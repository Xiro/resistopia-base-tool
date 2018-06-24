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
            [['date_of_birth'], 'validateDate'],
        ]);
    }

    public function validateDate()
    {
        if(1 !== preg_match('/[0-9]{2}.[0-9]{2}.[0-9]{4}/', $this->date_of_birth)) {
            $this->addError('date_of_birth', "Date of birth must be in format dd.mm.yyyy");
        }
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
            $rpn .= rand(10000, 99999);
            $alreadyExists = 0 < self::find()->where(["rpn" => $rpn])->count();
        } while ($alreadyExists);
        return $rpn;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $this->rpn = $this->createRpn();

            $accessKey = new AccessKey();
            $accessKey->access_key = 0;
            $accessKey->save();
            $this->access_key_id = $accessKey->id;
        }

        $this->updateToOne('team');
        $this->updateToOne('company');
        $this->updateToOne('citizenship');

        if(!$this->validate()) {
            return false;
        }

        $this->date_of_birth = implode("-", array_reverse(explode(".", $this->date_of_birth)));

        $accessMasks = [];
        if ($this->base_category_id && $this->baseCategory->accessMask) {
            $accessMasks[] = $this->baseCategory->accessMask;
        }
        if ($this->rank_id && $this->rank->accessMask) {
            $accessMasks[] = $this->rank->accessMask;
        }
        $this->accessKey->changeAccessMasks($accessMasks);

        return parent::save(false, $attributeNames);
    }

}