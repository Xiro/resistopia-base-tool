<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_mask".
 *
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property string $access_key
 * @property integer $read_only
 *
 * @property AccessKeyMask[] $accessKeyMasks
 * @property BaseCategory[] $baseCategories
 * @property Rank[] $ranks
 */
class AccessMask extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_mask';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'access_key'], 'required'],
            [['read_only'], 'integer'],
            [['name', 'key'], 'string', 'max' => 50],
            [['access_key'], 'string', 'max' => 28],
            [['key'], 'unique'],
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
            'key' => 'Key',
            'access_key' => 'Access Key',
            'read_only' => 'Read Only',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessKeyMasks()
    {
        return $this->hasMany(AccessKeyMask::className(), ['access_mask_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseCategories()
    {
        return $this->hasMany(BaseCategory::className(), ['access_mask_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRanks()
    {
        return $this->hasMany(Rank::className(), ['access_mask_id' => 'id']);
    }
}
