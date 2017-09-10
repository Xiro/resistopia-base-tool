<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Mission[] $missions
 * @property MissionCall[] $missionCalls
 */
class MissionType extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mission_type';
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
    public function getMissions()
    {
        return $this->hasMany(Mission::className(), ['mission_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionCalls()
    {
        return $this->hasMany(MissionCall::className(), ['mission_type_id' => 'id']);
    }
}
