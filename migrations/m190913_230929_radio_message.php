<?php

use yii\db\Migration;

/**
 * Class m190913_230929_radio_message
 */
class m190913_230929_radio_message extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE `radio_message` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `callsign` VARCHAR(5) NOT NULL,
            `message` VARCHAR(255) NOT NULL,
            `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        )
        ;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190913_230929_radio_message cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190913_230929_radio_message cannot be reverted.\n";

        return false;
    }
    */
}
