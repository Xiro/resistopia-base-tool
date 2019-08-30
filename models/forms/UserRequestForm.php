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
            [['sid'], 'required'],
        ]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if(YII_ENV === "dev" && $this->isNewRecord) {
            $this->approved = 1;
        }
        return parent::save($runValidation, $attributeNames);
    }


}