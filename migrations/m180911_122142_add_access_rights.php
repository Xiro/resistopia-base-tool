<?php

use yii\db\Migration;
use app\models\AccessCategory;
use app\models\AccessRight;

/**
 * Class m180911_122142_add_access_rights
 */
class m180911_122142_add_access_rights extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $missionCategory = AccessCategory::findOne(['name' => 'Missions']);

        $missionBlockCategory = new AccessCategory();
        $missionBlockCategory->name = "Mission Block";
        $missionBlockCategory->order = AccessCategory::find()->count() + 1;
        $missionBlockCategory->save();

        $rights = [
            [
                'key'                => 'mission/gate',
                'name'               => 'Hellgate Interface',
                'access_category_id' => $missionCategory->id
            ],
            [
                'key'                => 'mission-block/view',
                'name'               => 'View Mission Blocks',
                'access_category_id' => $missionBlockCategory->id
            ],
            [
                'key'                => 'mission-block/create',
                'name'               => 'Create Mission Blocks',
                'access_category_id' => $missionBlockCategory->id
            ],
            [
                'key'                => 'mission-block/update',
                'name'               => 'Update Mission Blocks',
                'access_category_id' => $missionBlockCategory->id
            ],
            [
                'key'                => 'mission-block/delete',
                'name'               => 'Delete Mission Blocks',
                'access_category_id' => $missionBlockCategory->id
            ],
        ];
        foreach ($rights as $rightData) {
            $model = new AccessRight();
            $model->setAttributes($rightData);
            $model->order = AccessRight::find()->count() + 1;
            $model->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180911_122142_add_access_rights cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180911_122142_add_access_rights cannot be reverted.\n";

        return false;
    }
    */
}
