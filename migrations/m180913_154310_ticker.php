<?php

use yii\db\Migration;

/**
 * Class m180913_154310_ticker
 */
class m180913_154310_ticker extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `ticker` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `message` VARCHAR(255) NOT NULL COLLATE 'utf8_bin',
            `active` TINYINT(1) NOT NULL DEFAULT '0',
            `order` INT(11) NOT NULL DEFAULT '0',
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
        echo "m180913_154310_ticker cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180913_154310_ticker cannot be reverted.\n";

        return false;
    }
    */
}
