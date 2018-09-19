<?php

use yii\db\Migration;
use app\models\MissionType;
use app\models\Mission;

/**
 * Class m180913_211004_fix_mission_types
 */
class m180913_211004_fix_mission_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $missionTypes = MissionType::find()
            ->groupBy('name')
            ->asArray()
            ->all();
        $missionTypes = array_column($missionTypes, 'name');

        foreach ($missionTypes as $missionTypeName) {
            /** @var MissionType[] $models */
            $models = MissionType::find()
                ->where(['name' => $missionTypeName])
                ->all();
            $firstModel = null;
            foreach ($models as $model) {
                if(!$firstModel) {
                    $firstModel = $model;
                    continue;
                }
                Mission::updateAll(
                    ['mission_type_id' => $firstModel->id],
                    ['mission_type_id' => $model->id]
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
        echo "m180913_211004_fix_mission_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180913_211004_fix_mission_types cannot be reverted.\n";

        return false;
    }
    */
}
