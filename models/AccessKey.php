<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "access_key".
 *
 * @property integer $id
 * @property array $accessList
 *
 * @property AccessRight[] $accessRights
 * @property AccessMask[] $accessMasks
 * @property Staff[] $staff
 * @property User[] $users
 */
class AccessKey extends ActiveRecord
{

    const CACHE_KEY_ACCESS_LIST = "AccessList:";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_key';
    }

    public function init(){
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'refreshCache']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'refreshCache']);
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'refreshCache']);
    }

    public function refreshCache()
    {
        $cacheKey = self::CACHE_KEY_ACCESS_LIST . $this->id;
        Yii::$app->cache->delete($cacheKey);
    }

    public function delete()
    {
        foreach ($this->accessMasks as $accessMask) {
            $this->unlink('accessMasks', $accessMask, true);
        }
        foreach ($this->users as $user) {
            $user->unlink('accessKey', $this);
        }
        foreach ($this->staff as $staff) {
            $staff->unlink('accessKey', $this);
        }

        parent::delete();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
        ];
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
            $this->unlink('accessMasks', $removeMask, true);
        }

        $addMasks = array_diff_key($newAccessMasks, $existingMasks);
        foreach ($addMasks as $addMask) {
            $this->link("accessMasks", $addMask);
        }
        $this->refreshCache();
    }

    public function getAccessList()
    {
        $accessList = ArrayHelper::map($this->accessRights, 'key', 'id');
        $accessList = array_merge($accessList, $this->getAccessListOfMasks());
        return $accessList;
    }

    public function getAccessListOfMasks()
    {
        $accessList = [];
        foreach ($this->accessMasks as $accessMask) {
            $accessList = array_merge($accessList, $accessMask->accessList);
        }
        return $accessList;
    }

    /**
     * @param $accessKeyId
     * @return array|mixed
     */
    public static function findAccessList($accessKeyId) {
        /** @var ActiveRecord|string $modelClass */
        $cacheKey = self::CACHE_KEY_ACCESS_LIST . $accessKeyId;
        $cache = Yii::$app->cache;
        if(false === ($accessList = $cache->get($cacheKey))) {
            $model = self::findOne($accessKeyId);
            if(!$model) {
                throw new \RuntimeException('Access Key with ID ' . $accessKeyId . ' not found');
            }
            $accessList = $model->getAccessList();
            Yii::$app->cache->set($cacheKey, $accessList);
        }
        return $accessList;
    }

    public function clearAccessListCache()
    {
        Yii::$app->cache->delete(self::CACHE_KEY_ACCESS_LIST . $this->id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessRights()
    {
        return $this->hasMany(AccessRight::class, ['id' => 'access_right_id'])->viaTable('access_key_right', ['access_key_id' => 'id']);
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
