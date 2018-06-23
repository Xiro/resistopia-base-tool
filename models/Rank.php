<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "rank".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property integer $access_mask_id
 * @property integer $order
 *
 * @property AccessMask $accessMask
 * @property Staff[] $staff
 */
class Rank extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_name'], 'required'],
            [['access_mask_id', 'order'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['short_name'], 'string', 'max' => 12],
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
            'short_name' => 'Short Name',
            'access_mask_id' => 'Access Mask ID',
            'order' => 'Order',
        ];
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        foreach ($this->staff as $staff) {
            $staff->unlink('rank', $this);
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
        return $this->hasMany(Staff::className(), ['rank_id' => 'id']);
    }
}
