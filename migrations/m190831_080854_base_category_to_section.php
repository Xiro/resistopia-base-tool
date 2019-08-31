<?php

use yii\db\Migration;

/**
 * Class m190831_080854_base_category_to_section
 */
class m190831_080854_base_category_to_section extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `staff`
            CHANGE COLUMN `base_category_id` `section_id` INT(11) NULL DEFAULT NULL AFTER `rank_id`;
        RENAME TABLE `base_category` TO `section`;

        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190831_080854_base_category_to_section cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190831_080854_base_category_to_section cannot be reverted.\n";

        return false;
    }
    */
}
