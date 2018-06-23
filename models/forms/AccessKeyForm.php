<?php

namespace app\models\forms;

use app\models\AccessKey;

class AccessKeyForm extends AccessKey
{

    public $accessBits = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['accessBits'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->access_key = 0;
        foreach ($this->accessBits as $bitPos) {
            $this->access_key |= 1 << $bitPos - 1;
        }
        return parent::save($runValidation, $attributeNames);
    }

}