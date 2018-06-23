<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "access_key".
 *
 * @property integer $id
 * @property string $access_key
 *
 * @property AccessMask[] $accessMasks
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
//            [['access_key'], 'required'],
        ];
    }

    public function afterFind()
    {
        $this->access_key = (int) $this->access_key;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'access_key' => 'Access Key',
        ];
    }

    public function addAccessMask(AccessMask $addMask)
    {
        $this->link("accessMasks", $addMask);
        $this->addMaskKey($addMask->access_key);
    }

    public function addMaskKey($addKey)
    {
        $this->access_key |= $addKey;
        $this->save();
    }

    public function removeAccessMask(AccessMask $removeMask)
    {
        $this->unlink('accessMasks', $removeMask, true);
        $this->removeMaskKey($removeMask->access_key);
    }

    public function removeMaskKey($removeKey)
    {
        $this->access_key = $this->access_key ^ ($removeKey & $this->access_key);
        foreach ($this->accessMasks as $otherMask) {
            $this->access_key |= $otherMask->access_key;
        }
        $this->save();
    }

    public function changeAccessMasks($newAccessMasks)
    {
        $newMaskIds = ArrayHelper::getColumn($newAccessMasks, "id");
        $newAccessMasks = array_combine($newMaskIds, $newAccessMasks);

        $existingMasks = $this->accessMasks;
        $existingMaskIds = ArrayHelper::getColumn($existingMasks, "id");
        $existingMasks = array_combine($existingMaskIds, $existingMasks);

        $removeMasks = array_diff_key($existingMasks, $newAccessMasks);
        foreach ($removeMasks as $removeMask) {
            $this->removeAccessMask($removeMask);
        }

        $addMasks = array_diff_key($newAccessMasks, $existingMasks);
        foreach ($addMasks as $addMask) {
            $this->addAccessMask($addMask);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessMasks()
    {
        return $this->hasMany(AccessMask::class, ['id' => 'access_mask_id'])->viaTable('access_key_mask', ['access_key_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::class, ['access_key_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['access_key_id' => 'id']);
    }
}
