<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "rank".
 *
 * @property integer $id
 * @property string $name
 *
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
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['rank_id' => 'id']);
    }
}
