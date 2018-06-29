<?php

namespace app\models\forms;

use app\models\AccessRight;
use app\models\AccessCategory;
use mate\yii\models\form\UpdateDynamicToOneTrait;

/**
 * AccessRightForm represents the form for the model `app\models\AccessRight`.
 */
class AccessRightForm extends AccessRight
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