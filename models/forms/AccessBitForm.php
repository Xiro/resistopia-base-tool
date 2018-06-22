<?php

namespace app\models\forms;

use app\models\AccessBit;
use app\models\AccessCategory;
use mate\yii\models\form\UpdateDynamicToOneTrait;

/**
 * AccessBitForm represents the form for the model `app\models\AccessBit`.
 */
class AccessBitForm extends AccessBit
{

    use UpdateDynamicToOneTrait;

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->updateToOne('accessCategory', [
            'creationAttributes' => [
                'order' => AccessCategory::find()->count() + 1,
            ]
        ]);
        return parent::save($runValidation, $attributeNames);
    }

}