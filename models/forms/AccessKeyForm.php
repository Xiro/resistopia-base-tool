<?php

namespace app\models\forms;

use app\models\AccessKey;
use app\models\AccessRight;
use mate\yii\models\form\UpdateToManyTrait;

class AccessKeyForm extends AccessKey
{

    use UpdateToManyTrait;

    public $accessRightsSelect = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['accessRightsSelect'], 'safe'],
        ]);
    }

    public function afterFind()
    {
        $this->accessRightsSelect = $this->accessList;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $isSaved = parent::save($runValidation, $attributeNames);
        if($isSaved) {
            $individualRights = array_diff($this->accessRightsSelect, $this->getAccessListOfMasks());
            $this->updateToMany('accessRights', AccessRight::class, $individualRights);
        }
        $this->clearAccessListCache();
        return $isSaved;
    }

}