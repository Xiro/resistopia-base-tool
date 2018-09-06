<?php

namespace app\models\forms;

use app\models\AccessKey;
use app\models\AccessMask;
use app\models\Staff;
use mate\yii\models\form\UpdateDynamicToOneTrait;
use yii\helpers\ArrayHelper;

/**
 * StaffForm represents the form for the model `app\models\Staff`.
 */
class StaffForm extends Staff
{

    use UpdateDynamicToOneTrait;

    public $accessMasks = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['accessMasks'], 'safe'],
            [['date_of_birth'], 'date', 'format' => 'dd.MM.yyyy'],
            [['forename', 'surname', 'nickname'], 'match', 'pattern' => '/^[a-z]{1}[a-z\-\.\,\s]*$/i'],
            [['forename', 'surname', 'nickname'], 'trim'],
        ]);
    }

    public function afterFind()
    {
        $this->date_of_birth = date('d.m.Y', strtotime($this->date_of_birth));

        $existingMasks = $this->accessKey->accessMasks;
        $existingMaskIds = ArrayHelper::getColumn($existingMasks, "id");
        $impliedMasks = $this->getImpliedAccessMasks();
        $impliedMaskIds = ArrayHelper::getColumn($impliedMasks, 'id');
        $this->accessMasks = array_diff($existingMaskIds, $impliedMaskIds);
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

    protected function getImpliedAccessMasks()
    {
        $accessMasks = [];
        if ($this->base_category_id && $this->baseCategory->accessMask) {
            $accessMasks[] = $this->baseCategory->accessMask;
        }
        if ($this->rank_id && $this->rank->accessMask) {
            $accessMasks[] = $this->rank->accessMask;
        }
        return $accessMasks;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $this->rpn = $this->createRpn();

            $accessKey = new AccessKey();
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

        $accessMasks = $this->getImpliedAccessMasks();
        $this->accessMasks = !is_array($this->accessMasks) ? [] : $this->accessMasks;
        foreach ($this->accessMasks as $accessMaskId) {
            $accessMasks[] = AccessMask::findOne($accessMaskId);
        }
        $this->accessKey->changeAccessMasks($accessMasks);

        return parent::save(false, $attributeNames);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->date_of_birth = date('d.m.Y', strtotime($this->date_of_birth));
        parent::afterSave($insert, $changedAttributes);
    }


}