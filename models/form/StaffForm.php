<?php

namespace app\models\form;

use app\models\Company;
use app\models\Access;
use app\models\Staff;
use app\models\StaffStatus;
use app\models\Team;
use yii\helpers\ArrayHelper;

class StaffForm extends Staff
{

    use UpdateToManyTrait;
    use UpdateDynamicToOneTrait;

    public $accessSelect;
    public $isIt = 1;
    public $isBlocked = 0;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->staff_status_id = StaffStatus::findOne(["name" => StaffStatus::STATUS_ALIVE]);
    }


    public function afterFind()
    {
        $this->isIt = $this->is_it === "Yes" ? true : false;
        $this->isBlocked = $this->is_blocked === "Yes" ? true : false;
        $this->accessSelect = ArrayHelper::map($this->accesses, "name", "id");
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
            [['category_id'], 'required'],
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
        $this->is_it = $this->isIt == "0" ? "No" : "Yes";
        $this->is_blocked = $this->isBlocked == "0" ? "No" : "Yes";
        $this->call_sign = !$this->call_sign ? null : $this->call_sign;

        $this->updateDynamicToOne("team_id", Team::className(), $this->team_id);
        $this->updateDynamicToOne("company_id", Company::className(), $this->company_id);

        if($this->isNewRecord || $this->getIsNewRecord()) {
            $this->rpn = $this->createRpn();
            parent::save($runValidation, $attributeNames);
        }
        $this->updateToMany("accesses", Access::className(), $this->accessSelect);

        return parent::save($runValidation, $attributeNames);
    }

}