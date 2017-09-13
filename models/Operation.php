<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "operation".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Mission[] $missions
 * @property Mission[] $activeMissions
 */
class Operation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operation';
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
        return $this->hasMany(Mission::className(), ['operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveMissions()
    {
        return $this->hasMany(Mission::className(), ['operation_id' => 'id'])
            ->where(["mission.mission_status_id" => MissionStatus::statusId(MissionStatus::STATUS_ACTIVE)]);
    }
}
