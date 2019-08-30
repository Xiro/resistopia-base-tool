<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "mission_status_history".
 *
 * @property integer $id
 * @property integer $mission_id
 * @property integer $mission_status_id
 * @property string $author_sid
 * @property string $created
 *
 * @property Mission $mission
 * @property MissionStatus $missionStatus
 * @property Staff $author
 */
class MissionStatusHistory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mission_status_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mission_id', 'mission_status_id', 'author_sid'], 'required'],
            [['mission_id', 'mission_status_id'], 'integer'],
            [['created'], 'safe'],
            [['author_sid'], 'string', 'max' => 8],
            [['mission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mission::className(), 'targetAttribute' => ['mission_id' => 'id']],
            [['mission_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => MissionStatus::className(), 'targetAttribute' => ['mission_status_id' => 'id']],
            [['author_sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['author_sid' => 'sid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mission_id' => 'Mission ID',
            'mission_status_id' => 'Mission Status ID',
            'author_sid' => 'Author SID',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMission()
    {
        return $this->hasOne(Mission::className(), ['id' => 'mission_id']);
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
    public function getAuthor()
    {
        return $this->hasOne(Staff::className(), ['sid' => 'author_sid']);
    }
}
