<?php

use yii\db\Migration;

/**
 * Class m180830_182444_callsign_validation
 */
class m180830_182444_callsign_validation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `staff`
            CHANGE COLUMN `callsign` `callsign` VARCHAR(5) NULL DEFAULT NULL COLLATE 'utf8_bin' AFTER `profession`;
        ");
        $this->execute("
        UPDATE staff SET callsign = NULL WHERE callsign = '';
        ALTER TABLE `staff`
	      ADD UNIQUE INDEX `callsign` (`callsign`);
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180830_182444_callsign_validation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_182444_callsign_validation cannot be reverted.\n";

        return false;
    }
    */
}
