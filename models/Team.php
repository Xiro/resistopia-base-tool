<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "team".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Staff[] $staff
 */
class Team extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['team_id' => 'id']);
    }
}
