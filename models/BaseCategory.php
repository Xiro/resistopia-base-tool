<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "base_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property integer $access_mask_id
 * @property integer $order
 *
 * @property AccessMask $accessMask
 * @property Staff[] $staff
 */
class BaseCategory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['access_mask_id', 'order'], 'integer'],
            [['name', 'key'], 'string', 'max' => 50],
            [['access_mask_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessMask::className(), 'targetAttribute' => ['access_mask_id' => 'id']],
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
            'access_mask_id' => 'Access Mask ID',
            'order' => 'Order',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord) {
            $this->key = Inflector::camel2id(Inflector::camelize($this->name));
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        foreach ($this->staff as $staff) {
            $staff->unlink('baseCategory', $this);
        }
        return parent::delete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessMask()
    {
        return $this->hasOne(AccessMask::className(), ['id' => 'access_mask_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['base_category_id' => 'id']);
    }
}
