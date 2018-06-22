<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_bit".
 *
 * @property integer $bit_pos
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
class AccessBit extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_bit';
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
            'bit_pos' => 'Bit Pos',
            'key' => 'Key',
            'name' => 'Name',
            'comment' => 'Comment',
            'order' => 'Order',
            'access_category_id' => 'Access Category ID',
        ];
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
        return $this->hasMany(AccessSecurityArea::className(), ['access_bit_pos' => 'bit_pos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffFileMemos()
    {
        return $this->hasMany(StaffFileMemo::className(), ['access_bit_id' => 'bit_pos']);
    }
}
