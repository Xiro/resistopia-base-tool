<?php

use yii\db\Migration;

/**
 * Class m190901_195840_make_section_department_optional
 */
class m190901_195840_make_section_department_optional extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `section`
	    ALTER `department` DROP DEFAULT;
        ALTER TABLE `section`
            CHANGE COLUMN `department` `department` VARCHAR(255) NULL COLLATE 'utf8_bin' AFTER `section`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190901_195840_make_section_department_optional cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190901_195840_make_section_department_optional cannot be reverted.\n";

        return false;
    }
    */
}
