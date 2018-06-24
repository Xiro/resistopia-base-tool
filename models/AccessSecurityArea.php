<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_security_area".
 *
 * @property integer $id
 * @property string $name
 * @property integer $access_bit_pos
 *
 * @property AccessBit $accessBitPos
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
            [['name', 'access_bit_pos'], 'required'],
            [['access_bit_pos'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['access_bit_pos'], 'exist', 'skipOnError' => true, 'targetClass' => AccessBit::className(), 'targetAttribute' => ['access_bit_pos' => 'bit_pos']],
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
            'access_bit_pos' => 'Access Right',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessBitPos()
    {
        return $this->hasOne(AccessBit::className(), ['bit_pos' => 'access_bit_pos']);
    }
}
