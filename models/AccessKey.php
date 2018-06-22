<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_key".
 *
 * @property integer $id
 * @property string $access_key
 *
 * @property AccessKeyMask[] $accessKeyMasks
 * @property Staff[] $staff
 * @property User[] $users
 */
class AccessKey extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_key';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['access_key'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_key' => 'Access Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessKeyMasks()
    {
        return $this->hasMany(AccessKeyMask::className(), ['access_key_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['access_key_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['access_key_id' => 'id']);
    }
}
