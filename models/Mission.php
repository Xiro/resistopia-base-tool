<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $RP
 * @property integer $FP
 * @property string $zone
 * @property string $started
 * @property string $ended
 * @property string $debrief_comment
 * @property integer $mission_type_id
 * @property integer $mission_status_id
 *
 * @property MissionStatus $missionStatus
 * @property MissionType $missionType
 */
class Mission extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'RP', 'FP', 'zone', 'mission_type_id', 'mission_status_id'], 'required'],
            [['description', 'zone', 'debrief_comment'], 'string'],
            [['RP', 'FP', 'mission_type_id', 'mission_status_id'], 'integer'],
            [['started', 'ended'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['mission_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => MissionStatus::className(), 'targetAttribute' => ['mission_status_id' => 'id']],
            [['mission_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MissionType::className(), 'targetAttribute' => ['mission_type_id' => 'id']],
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
            'description' => 'Description',
            'RP' => 'Rp',
            'FP' => 'Fp',
            'zone' => 'Zone',
            'started' => 'Started',
            'ended' => 'Ended',
            'debrief_comment' => 'Debrief Comment',
            'mission_type_id' => 'Mission Type ID',
            'mission_status_id' => 'Mission Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionStatus()
    {
        return $this->hasOne(MissionStatus::className(), ['id' => 'mission_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionType()
    {
        return $this->hasOne(MissionType::className(), ['id' => 'mission_type_id']);
    }
}
