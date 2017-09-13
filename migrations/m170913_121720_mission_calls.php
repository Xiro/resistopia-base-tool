<?php

use yii\db\Migration;

class m170913_121720_mission_calls extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE `mission_call`
            ALTER `due` DROP DEFAULT,
            ALTER `max_duration` DROP DEFAULT,
            ALTER `fighter` DROP DEFAULT,
            ALTER `radio` DROP DEFAULT,
            ALTER `medic` DROP DEFAULT,
            ALTER `technician` DROP DEFAULT,
            ALTER `science` DROP DEFAULT,
            ALTER `guard` DROP DEFAULT,
            ALTER `vip` DROP DEFAULT;
        ALTER TABLE `mission_call`
            CHANGE COLUMN `due` `scheduled_start` DATETIME NOT NULL AFTER `zone`,
            CHANGE COLUMN `max_duration` `scheduled_end` DATETIME NOT NULL AFTER `scheduled_start`,
            CHANGE COLUMN `fighter` `fighter` SMALLINT(6) NULL AFTER `scheduled_end`,
            CHANGE COLUMN `radio` `radio` TINYINT(4) NULL AFTER `fighter`,
            CHANGE COLUMN `medic` `medic` TINYINT(4) NULL AFTER `radio`,
            CHANGE COLUMN `technician` `technician` TINYINT(4) NULL AFTER `medic`,
            CHANGE COLUMN `science` `science` TINYINT(4) NULL AFTER `technician`,
            CHANGE COLUMN `guard` `guard` TINYINT(4) NULL AFTER `science`,
            CHANGE COLUMN `vip` `vip` TINYINT(4) NULL AFTER `guard`;
        ");
    }

    public function safeDown()
    {
        echo "m170913_121720_mission_calls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170913_121720_mission_calls cannot be reverted.\n";

        return false;
    }
    */
}
