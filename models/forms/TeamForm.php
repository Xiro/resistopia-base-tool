<?php

namespace app\models\forms;

use app\models\Staff;
use app\models\Team;
use mate\yii\models\form\UpdateToManyTrait;

/**
 * TeamForm represents the form for the model `app\models\Team`.
 */
class TeamForm extends Team
{

    use UpdateToManyTrait;

    public $staffSelect = [];
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
            [[
                "staffSelect",
            ], "safe"],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if($this->isNewRecord || $this->getIsNewRecord()) {
            parent::save($runValidation, $attributeNames);
        }

        $this->updateToMany("staff", Staff::class, $this->staffSelect, false, 'rpn');

        return parent::save($runValidation, $attributeNames);
    }

}