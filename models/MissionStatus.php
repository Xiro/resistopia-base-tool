<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission_status".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Mission[] $missions
 */
class MissionStatus extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mission_status';
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
        return $this->hasMany(Mission::className(), ['mission_status_id' => 'id']);
    }
}
