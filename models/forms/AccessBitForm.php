<?php

namespace app\models\forms;

use app\models\AccessBit;

/**
 * AccessBitForm represents the form for the model `app\models\AccessBit`.
 */
class AccessBitForm extends AccessBit
{

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

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        return parent::save($runValidation, $attributeNames);
    }

}