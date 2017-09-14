<?php

use yii\db\Migration;

class m170914_185221_create_from_mission_call extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE `mission_call`
            ADD COLUMN `operation_id` INT NULL DEFAULT NULL AFTER `vip`;
        ");
    }

    public function safeDown()
    {
        echo "m170914_185221_create_from_mission_call cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170914_185221_create_from_mission_call cannot be reverted.\n";

        return false;
    }
    */
}
