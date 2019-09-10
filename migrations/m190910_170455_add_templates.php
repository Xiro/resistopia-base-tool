<?php

use yii\db\Migration;

/**
 * Class m190910_170455_add_templates
 */
class m190910_170455_add_templates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        #INSERT INTO `base_tool`.`mission_status` (`name`) VALUES ('template');
        ALTER TABLE `mission`
            ALTER `troop_name` DROP DEFAULT,
            ALTER `troop_strength` DROP DEFAULT;
        ALTER TABLE `mission`
            CHANGE COLUMN `troop_name` `troop_name` VARCHAR(128) NULL COLLATE 'utf8_bin' AFTER `name`,
            CHANGE COLUMN `troop_strength` `troop_strength` INT(11) NULL AFTER `troop_name`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190910_170455_add_templates cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190910_170455_add_templates cannot be reverted.\n";

        return false;
    }
    */
}
