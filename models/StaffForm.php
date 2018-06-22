<?php

namespace app\models;

use DateTime;
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

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [[
                "accessSelect",
                "isIt",
                "isBlocked",
            ], "safe"],
            [['base_category_id'], 'required'],
        ]);
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
        $this->updateDynamicToOne("team_id", Team::class, $this->team_id);
        $this->updateDynamicToOne("company_id", Company::class, $this->company_id);
        $this->updateDynamicToOne("citizenship_id", Citizenship::class, $this->citizenship_id);
        $this->date_of_birth = date('Y-m-d', strtotime($this->date_of_birth));
//        $this->date_of_birth = $timestamp = DateTime::createFromFormat('!d.m.Y', $this->date_of_birth)->format('c');

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