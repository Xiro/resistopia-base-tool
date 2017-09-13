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
 * @property integer $operation_id
 * @property integer $mission_type_id
 * @property integer $mission_status_id
 *
 * @property MissionStatus $missionStatus
 * @property MissionType $missionType
 * @property Operation $operation
 * @property MissionStaff[] $missionStaff
 * @property Staff[] $staff
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
            [['name', 'RP', 'FP', 'zone', 'operation_id', 'mission_type_id', 'mission_status_id'], 'required'],
            [['description', 'zone', 'debrief_comment'], 'string'],
            [['RP', 'FP', 'operation_id', 'mission_type_id', 'mission_status_id'], 'integer'],
            [['started', 'ended'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['mission_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => MissionStatus::className(), 'targetAttribute' => ['mission_status_id' => 'id']],
            [['mission_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MissionType::className(), 'targetAttribute' => ['mission_type_id' => 'id']],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['operation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'name'              => 'Name',
            'description'       => 'Description',
            'RP'                => 'Rp',
            'FP'                => 'Fp',
            'zone'              => 'Zone',
            'started'           => 'Started',
            'ended'             => 'Ended',
            'debrief_comment'   => 'Debrief Comment',
            'operation_id'      => 'Operation ID',
            'mission_type_id'   => 'Mission Type ID',
            'mission_status_id' => 'Mission Status ID',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {

        if (
            (
                $this->mission_status_id == MissionStatus::statusId(MissionStatus::STATUS_COMPLETED)
                || $this->mission_status_id == MissionStatus::statusId(MissionStatus::STATUS_FAILED)
            )
            && empty($this->ended)
        ) {
            $this->ended = date("Y-m-d\TH:m:i", time());
        }
        return parent::save($runValidation, $attributeNames);
    }


    public function getCutDescription($max = 40)
    {
        return $this->cutText($this->description, $max);
    }

    public function getCutDebriefComment($max = 40)
    {
        return $this->cutText($this->debrief_comment, $max);
    }

    protected function cutText($text, $max)
    {
        if (strlen($text) > $max) {
            $offset = ($max - 3) - strlen($text);
            $text = substr($text, 0, strrpos($text, ' ', $offset)) . '...';
        }
        return $text;
    }

    public function delete()
    {
        MissionStaff::deleteAll(["mission_id" => $this->id]);
        return parent::delete();
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::className(), ['id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionStaff()
    {
        return $this->hasMany(MissionStaff::className(), ['mission_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['id' => 'staff_id'])->viaTable('mission_staff', ['mission_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getCallSigns()
    {
        $callSigns = $this->hasMany(Staff::className(), ['id' => 'staff_id'])
            ->viaTable('mission_staff', ['mission_id' => 'id'])
            ->where("staff.call_sign IS NOT NULL")->asArray()->all();
        return array_column($callSigns, "call_sign");
    }
}
