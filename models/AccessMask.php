<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "access_mask".
 *
 * @property integer $id
 * @property string $name
 * @property integer $protected
 * @property array $accessList
 *
 * @property AccessRight[] $accessRights
 * @property Section[] $baseCategories
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
            [['name'], 'required'],
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
            'protected' => 'Protected',
        ];
    }

    public function getAccessList()
    {
        $accessList = ArrayHelper::map($this->accessRights, 'key', 'id');
        return $accessList;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessRights()
    {
        return $this->hasMany(AccessRight::class, ['id' => 'access_right_id'])->viaTable('access_mask_right', ['access_mask_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseCategories()
    {
        return $this->hasMany(Section::className(), ['access_mask_id' => 'id']);
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
