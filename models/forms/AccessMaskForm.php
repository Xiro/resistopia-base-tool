<?php

namespace app\models\forms;

use app\models\AccessMask;

/**
 * AccessMaskForm represents the form for the model `app\models\AccessMask`.
 */
class AccessMaskForm extends AccessMask
{

    public $accessBits = [];

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