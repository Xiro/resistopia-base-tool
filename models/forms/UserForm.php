<?php

namespace app\models\forms;

use app\models\AccessKey;
use app\models\User;

/**
 * UserForm represents the form for the model `app\models\User`.
 */
class UserForm extends User
{

    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['password', 'password_repeat'], 'safe'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'string', 'min' => 6, 'tooShort' => 'Password should contain at least 6 characters'],
        ], $this->isNewRecord ? [
            ['password', 'required'],
            ['password_repeat', 'required'],
            ['password_repeat', 'matchPasswords'],
        ] : []);
    }

    public function matchPasswords($attribute)
    {
        if ($this->password_repeat !== $this->password) {
            $this->addError($attribute, 'The passwords do not match');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password'       => $this->isNewRecord ? "Password" : "New Password",
            'repeatPassword' => $this->isNewRecord ? "Repeat Password" : "Repeat New Password",
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if($this->isNewRecord) {
            if($this->rpn) {
                $this->access_key_id = $this->staff->access_key_id;
            } else {
                $addAccessKey = new AccessKey();
                $addAccessKey->access_key = 0;
                $addAccessKey->save();
                $this->access_key_id = $addAccessKey->id;
            }
            $this->generateAuthKey();
        }
        if(!empty($this->password)) {
            $this->setPassword($this->password);
        }
        return parent::save($runValidation, $attributeNames);
    }

}