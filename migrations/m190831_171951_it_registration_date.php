<?php

use yii\db\Migration;

/**
 * Class m190831_171951_it_registration_date
 */
class m190831_171951_it_registration_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `staff`
            ADD COLUMN `registered` DATE NULL DEFAULT NULL COMMENT 'IT date of registration';
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190831_171951_it_registration_date cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190831_171951_it_registration_date cannot be reverted.\n";

        return false;
    }
    */
}
