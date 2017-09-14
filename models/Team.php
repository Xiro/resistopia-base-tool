<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "team".
 *
 * @property integer $id
 * @property string $name
 * @property string $comment
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
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
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
            'comment' => 'Comment',
        ];
    }

    public function delete()
    {
        Staff::updateAll(["team_id" => null], ["team_id" => $this->id]);
        return parent::delete();
    }

    /**
     * Get the sum of all RP that were already paid to a team
     * @return integer
     */
    public function getPaidRP()
    {
        return $this->getRpSum("Yes");
    }

    /**
     * Get the sum of all RP that must yet be paid to a team
     * @return integer
     */
    public function getUnpaidRP()
    {
        return $this->getRpSum("No");
    }

    /**
     * @param string $paid
     * @return integer
     */
    protected function getRpSum($paid = "Yes")
    {
        $rpSum = MissionStaff::find()
            ->joinWith("mission")
            ->where(["staff_id" => $this->getStaff()->select("id")])
            ->andWhere(["paid" => $paid])
            ->andWhere(["mission.mission_status_id" => MissionStatus::completedId()])
            ->asArray()
            ->sum("mission.RP");
        return $rpSum ? $rpSum : 0;
    }

    public function getActiveMissions()
    {
        return $this->getMissions(MissionStatus::activeId());
    }

    public function getPastMissions()
    {
        return $this->getMissions([
            MissionStatus::completedId(),
            MissionStatus::failedId()
        ]);
    }

    public function getPendingMissions()
    {
        return $this->getMissions(MissionStatus::pendingId());
    }

    protected function getMissions($statusId)
    {
        return Mission::find()
            ->joinWith("missionStaff")
            ->where(["mission_staff.staff_id" => $this->getStaff()->select("id")])
            ->andWhere(["mission.mission_status_id" => $statusId])
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['team_id' => 'id']);
    }
}
