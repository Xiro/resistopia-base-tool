<?php

namespace app\models\forms;

/**
 * UserForm represents the form for the model `app\models\User`.
 */
class ForgotPasswordForm extends UserForm
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password', 'required'],
            ['password_repeat', 'required'],
            ['password_repeat', 'matchPasswords'],
        ]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->approved = 0;
        return parent::save($runValidation, $attributeNames);
    }

}