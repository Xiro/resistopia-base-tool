<?php

use yii\db\Migration;

class m170914_123119_comments extends Migration
{
    public function safeUp()
    {
        $this->execute("ALTER TABLE `team`
	      ADD COLUMN `comment` TEXT NULL DEFAULT NULL AFTER `name`;");
        $this->execute("ALTER TABLE `staff`
	      ADD COLUMN `comment` TEXT NULL DEFAULT NULL AFTER `password`;");
    }

    public function safeDown()
    {
        echo "m170914_123119_comments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170914_123119_comments cannot be reverted.\n";

        return false;
    }
    */
}
