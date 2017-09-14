<?php

use yii\db\Migration;

class m170914_171811_access extends Migration
{
    public function safeUp()
    {
        $this->execute("RENAME TABLE `role` TO `access`;");
        $this->execute("ALTER TABLE `staff_role`
          CHANGE COLUMN `role_id` `access_id` INT(11) NOT NULL AFTER `staff_id`;
          RENAME TABLE `staff_role` TO `staff_access`;");
        $this->execute("UPDATE `access` SET `name`='Mission' WHERE `name`='Admin';");
        $this->execute("UPDATE `access` SET `name`='Staff' WHERE `name`='CIC';");
    }

    public function safeDown()
    {
        echo "m170914_171811_access cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170914_171811_access cannot be reverted.\n";

        return false;
    }
    */
}
