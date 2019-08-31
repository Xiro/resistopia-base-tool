<?php

use yii\db\Migration;

/**
 * Class m190831_144251_remove_status_it_and_status_be13
 */
class m190831_144251_remove_status_it_and_status_be13 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `staff`
            DROP COLUMN `status_it`,
            DROP COLUMN `status_be13`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190831_144251_remove_status_it_and_status_be13 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190831_144251_remove_status_it_and_status_be13 cannot be reverted.\n";

        return false;
    }
    */
}
