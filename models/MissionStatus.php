<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission_status".
 *
 * @property integer $id
 * @property string $name
 *
 * @property MissionStatusHistory[] $missionStatusHistories
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
    public function getMissionStatusHistories()
    {
        return $this->hasMany(MissionStatusHistory::className(), ['mission_status_id' => 'id']);
    }
}
