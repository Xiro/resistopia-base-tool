<?php

namespace app\models\form;

use app\models\Company;
use app\models\Role;
use app\models\Staff;
use app\models\StaffStatus;
use app\models\Team;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class StaffForm extends Staff
{

    public $roleSelect;
    public $team;
    public $company;
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
        $this->team = $this->team_id ? $this->team_id : null;
        $this->company = $this->company_id ? $this->company_id : null;
        $this->roleSelect = ArrayHelper::map($this->roles, "name", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [[
                "roleSelect",
                "team",
                "company",
                "isIt",
                "isBlocked",
            ], "safe"],
            [['category_id'], 'required'],
            [['team'], 'string', 'max' => 50],
            [['company'], 'string', 'max' => 50],
        ]);
    }

    public function createRpn()
    {
        do {
            $rpn = "";
            $rpn .= substr($this->forename, 0, 1);
            $rpn .= substr($this->surname, 0, 1);
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

        $this->updateDynamicToOne("team_id", Team::className(), $this->team);
        $this->updateDynamicToOne("company_id", Company::className(), $this->company);

        if($this->isNewRecord || $this->getIsNewRecord()) {
            $this->rpn = $this->createRpn();
            parent::save($runValidation, $attributeNames);
        }
        $this->updateManyToMany("roles", Role::className(), $this->roleSelect);

        return parent::save($runValidation, $attributeNames);
    }

    public function updateDynamicToOne($idColumn, $modelClass, $value, $modelValueAttr = "name")
    {
        if(!$value) {
            return null;
        }
        /** @var ActiveRecord $modelClass */
        $hasModel = 0 < $modelClass::find()->where(["id" => $value])->count();
        if($hasModel) {
            $this->$idColumn = $value;
        } else {
            /** @var ActiveRecord $addModel */
            $addModel = new $modelClass;
            $addModel->$modelValueAttr = $value;
            $addModel->save();
            $this->$idColumn = $addModel->id;
        }
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