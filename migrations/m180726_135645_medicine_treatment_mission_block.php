<?php

use yii\db\Migration;

/**
 * Class m180726_135645_medicine_treatment_mission_block
 */
class m180726_135645_medicine_treatment_mission_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `medicine_treatment`
            ADD COLUMN `mission_block_id` INT NULL AFTER `updated`;
        ");
        $this->execute("ALTER TABLE `medicine_treatment`
            ADD CONSTRAINT `FK_medicine_treatment_mission_block` FOREIGN KEY (`mission_block_id`) REFERENCES `mission_block` (`id`);
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180726_135645_medicine_treatment_mission_block cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180726_135645_medicine_treatment_mission_block cannot be reverted.\n";

        return false;
    }
    */
}
