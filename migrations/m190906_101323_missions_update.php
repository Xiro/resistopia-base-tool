<?php

use yii\db\Migration;

/**
 * Class m190906_101323_missions_update
 */
class m190906_101323_missions_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $missions = \app\models\Mission::find()->all();
        foreach ($missions as $mission) {
            $mission->delete();
        }

        $operations = \app\models\Operation::find()->all();
        foreach ($operations as $operation) {
            $operation->delete();
        }

        $this->execute("
        ALTER TABLE `mission`
        ALTER `zone` DROP DEFAULT;
        ALTER TABLE `mission`
            ADD COLUMN `troop_name` VARCHAR(128) NOT NULL AFTER `mission_name`,
            ADD COLUMN `troop_strength` INT NOT NULL AFTER `troop_name`,
            CHANGE COLUMN `zone` `zone` ENUM('1','2','3') NULL COLLATE 'utf8_bin' AFTER `note`;
            ALTER TABLE `mission`

        ");

        $missionTypes = \app\models\MissionType::find()->all();
        foreach ($missionTypes as $missionType) {
            $missionType->delete();
        }

        $newMissionTypes = ['Patrouille', 'Aufklärung', 'Auftrag', 'Rettung', 'Kampf'];
        foreach ($newMissionTypes as $newMissionType) {
            $addMissionType = new \app\models\MissionType();
            $addMissionType->name = $newMissionType;
            $addMissionType->save();
        }

        $missionStatuses = \app\models\MissionStatus::find()->all();
        foreach ($missionStatuses as $missionStatus) {
            $missionStatus->delete();
        }

        $newMissionStatuses = ['OT', 'planing', 'active', 'completed'];
        foreach ($newMissionStatuses as $newMissionStatus) {
            $addMissionStatus = new \app\models\MissionStatus();
            $addMissionStatus->name = $newMissionStatus;
            $addMissionStatus->save();
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190906_101323_missions_update cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190906_101323_missions_update cannot be reverted.\n";

        return false;
    }
    */
}
