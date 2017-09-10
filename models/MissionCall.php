<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission_call".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $RP
 * @property integer $FP
 * @property string $zone
 * @property string $due
 * @property string $max_duration
 * @property integer $fighter
 * @property integer $radio
 * @property integer $medic
 * @property integer $technician
 * @property integer $science
 * @property integer $guard
 * @property integer $vip
 * @property integer $mission_type_id
 *
 * @property MissionType $missionType
 */
class MissionCall extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mission_call';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'RP', 'FP', 'zone', 'due', 'max_duration'], 'required'],
            [['description', 'zone'], 'string'],
            [['RP', 'FP', 'fighter', 'radio', 'medic', 'technician', 'science', 'guard', 'vip', 'mission_type_id'], 'integer'],
            [['due', 'max_duration'], 'safe'],
            [['name'], 'string', 'max' => 50],
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
            'due' => 'Due',
            'max_duration' => 'Max Duration',
            'fighter' => 'Fighter',
            'radio' => 'Radio',
            'medic' => 'Medic',
            'technician' => 'Technician',
            'science' => 'Science',
            'guard' => 'Guard',
            'vip' => 'Vip',
            'mission_type_id' => 'Mission Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionType()
    {
        return $this->hasOne(MissionType::className(), ['id' => 'mission_type_id']);
    }
}
