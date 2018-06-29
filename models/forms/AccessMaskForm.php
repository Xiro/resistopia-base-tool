<?php

namespace app\models\forms;

use app\models\AccessMask;
use app\models\AccessRight;
use mate\yii\models\form\UpdateToManyTrait;

/**
 * AccessMaskForm represents the form for the model `app\models\AccessMask`.
 */
class AccessMaskForm extends AccessMask
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
            $this->updateToMany('accessRights', AccessRight::class, $this->accessRightsSelect);
            foreach ($this->accessKeys as $accessKey) {
                $accessKey->clearAccessListCache();
            }
        }
        return $isSaved;
    }

}