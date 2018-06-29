<?php

namespace app\models\forms;

use app\models\AccessMask;

/**
 * AccessMaskForm represents the form for the model `app\models\AccessMask`.
 */
class AccessMaskForm extends AccessMask
{

    public $accessRights = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['accessRights'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $oldKey = $this->access_key;
        $this->access_key = 0;
        foreach ($this->accessRights as $bitPos) {
            $this->access_key |= 1 << $bitPos - 1;
        }
        $isSaved = parent::save($runValidation, $attributeNames);
        if($isSaved) {
            foreach ($this->accessKeys as $accessKey) {
                $accessKey->removeMaskKey($oldKey);
                $accessKey->addMaskKey($this->access_key);
            }
        }
        return $isSaved;
    }

}