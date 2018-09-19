<?php

use yii\db\Migration;
use app\models\MissionStatus;
use app\models\MissionStatusHistory;
use app\models\Mission;

/**
 * Class m180913_211004_fix_mission_status
 */
class m180913_211004_fix_mission_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $missionStatuses = MissionStatus::find()
            ->groupBy('name')
            ->asArray()
            ->all();
        $missionStatuses = array_column($missionStatuses, 'name');

        foreach ($missionStatuses as $missionStatusName) {
            /** @var MissionStatus[] $models */
            $models = MissionStatus::find()
                ->where(['name' => $missionStatusName])
                ->all();
            $firstModel = null;
            foreach ($models as $model) {
                if(!$firstModel) {
                    $firstModel = $model;
                    continue;
                }
                Mission::updateAll(
                    ['mission_status_id' => $firstModel->id],
                    ['mission_status_id' => $model->id]
                );
                MissionStatusHistory::updateAll(
                    ['mission_status_id' => $firstModel->id],
                    ['mission_status_id' => $model->id]
                );
                $model->delete();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180913_211004_fix_mission_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180913_211004_fix_mission_status cannot be reverted.\n";

        return false;
    }
    */
}
