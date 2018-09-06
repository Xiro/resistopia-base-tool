<?php

use yii\db\Migration;

/**
 * Class m180905_113544_add_mission_block_reason
 */
class m180905_113544_add_mission_block_reason extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `mission_block`
            ADD COLUMN `reason` TEXT NULL DEFAULT NULL AFTER `unblock_time`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180905_113544_add_mission_block_reason cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180905_113544_add_mission_block_reason cannot be reverted.\n";

        return false;
    }
    */
}
