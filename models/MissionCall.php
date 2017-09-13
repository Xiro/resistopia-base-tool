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
 * @property string $scheduled_start
 * @property string $scheduled_end
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
            [['name', 'RP', 'FP', 'zone', 'scheduled_start', 'scheduled_end'], 'required'],
            [['description', 'zone'], 'string'],
            [['RP', 'FP', 'fighter', 'radio', 'medic', 'technician', 'science', 'guard', 'vip', 'mission_type_id'], 'integer'],
            [['scheduled_start', 'scheduled_end'], 'safe'],
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
            'scheduled_start' => 'Scheduled Start',
            'scheduled_end' => 'Scheduled End',
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
