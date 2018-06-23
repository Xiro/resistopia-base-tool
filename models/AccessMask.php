<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_mask".
 *
 * @property integer $id
 * @property string $name
 * @property string $access_key
 * @property integer $protected
 *
 * @property BaseCategory[] $baseCategories
 * @property Rank[] $ranks
 * @property AccessKey[] $accessKeys
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
            [['protected'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
            'access_key' => 'Access Key',
            'protected' => 'Protected',
        ];
    }

    public function afterFind()
    {
        $this->access_key = (int) $this->access_key;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessKeys()
    {
        return $this->hasMany(AccessKey::class, ['id' => 'access_key_id'])->viaTable('access_key_mask', ['access_mask_id' => 'id']);
    }
}
