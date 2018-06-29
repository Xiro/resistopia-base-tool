<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_security_area".
 *
 * @property integer $id
 * @property string $name
 * @property integer $access_right_id
 *
 * @property AccessRight $accessRight
 */
class AccessSecurityArea extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_security_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'access_right_id'], 'required'],
            [['access_right_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['access_right_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessRight::className(), 'targetAttribute' => ['access_right_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'access_right_id' => 'Access Right ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessRight()
    {
        return $this->hasOne(AccessRight::className(), ['id' => 'access_right_id']);
    }
}
