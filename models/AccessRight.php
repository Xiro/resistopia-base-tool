<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_right".
 *
 * @property integer $id
 * @property string $key
 * @property string $name
 * @property string $comment
 * @property integer $order
 * @property integer $access_category_id
 *
 * @property AccessCategory $accessCategory
 * @property AccessSecurityArea[] $accessSecurityAreas
 * @property StaffFileMemo[] $staffFileMemos
 */
class AccessRight extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_right';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'access_category_id'], 'required'],
            [['comment'], 'string'],
            [['order'], 'integer'],
            [['key', 'name'], 'string', 'max' => 50],
            [['key'], 'unique'],
            [['access_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessCategory::className(), 'targetAttribute' => ['access_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'name' => 'Name',
            'comment' => 'Comment',
            'order' => 'Order',
            'access_category_id' => 'Access Category ID',
        ];
    }

    public function isInKey($accessKey)
    {
        return (bool) ($accessKey & (1 << $this->id - 1));
    }

    public function delete()
    {

        Yii::$app->db->createCommand("DELETE FROM access_key_right WHERE access_right_id = :access_right_id")
            ->bindValue("access_right_id", $this->id)
            ->execute();
        Yii::$app->db->createCommand("DELETE FROM access_mask_right WHERE access_right_id = :access_right_id")
            ->bindValue("access_right_id", $this->id)
            ->execute();
        return parent::delete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessCategory()
    {
        return $this->hasOne(AccessCategory::className(), ['id' => 'access_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessSecurityAreas()
    {
        return $this->hasMany(AccessSecurityArea::className(), ['access_right_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffFileMemos()
    {
        return $this->hasMany(StaffFileMemo::className(), ['access_right_id' => 'id']);
    }
}
