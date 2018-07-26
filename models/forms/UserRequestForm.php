<?php


namespace app\models\forms;


class UserRequestForm extends UserForm
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['rpn'], 'required'],
        ]);
    }

}