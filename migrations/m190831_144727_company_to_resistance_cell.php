<?php

use yii\db\Migration;

/**
 * Class m190831_144727_company_to_resistance_cell
 */
class m190831_144727_company_to_resistance_cell extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `staff`
                ADD COLUMN `resistance_cell_id` INT(11) NULL DEFAULT NULL AFTER `special_function_id`,
                DROP COLUMN `company_id`,
                DROP FOREIGN KEY `FK_staff_company`;
            
            ALTER TABLE `staff`
                CHANGE COLUMN `resistance_cell_id` `resistance_cell_id` INT(11) NULL DEFAULT NULL AFTER `rank_id`,
                ADD CONSTRAINT `FK_staff_resistance_cell` FOREIGN KEY (`resistance_cell_id`) REFERENCES `resistance_cell` (`id`);
                
            DROP TABLE `company`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190831_144727_company_to_resistance_cell cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190831_144727_company_to_resistance_cell cannot be reverted.\n";

        return false;
    }
    */
}
