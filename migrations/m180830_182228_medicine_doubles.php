<?php

use yii\db\Migration;

/**
 * Class m180830_182228_medicine_doubles
 */
class m180830_182228_medicine_doubles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `medicine_treatment`
            CHANGE COLUMN `pulse` `pulse` DOUBLE NULL DEFAULT NULL AFTER `pupils`,
            CHANGE COLUMN `temperature` `temperature` DOUBLE NULL DEFAULT NULL AFTER `pulse`,
            CHANGE COLUMN `blood_pressure_systolic` `blood_pressure_systolic` DOUBLE NULL DEFAULT NULL AFTER `temperature`,
            CHANGE COLUMN `blood_pressure_diastolic` `blood_pressure_diastolic` DOUBLE NULL DEFAULT NULL AFTER `blood_pressure_systolic`;
        ");
        $this->execute("
        ALTER TABLE `medicine_checkup`
            CHANGE COLUMN `pulse` `pulse` DOUBLE NULL DEFAULT NULL AFTER `pupils`,
            CHANGE COLUMN `temperature` `temperature` DOUBLE NULL DEFAULT NULL AFTER `pulse`,
            CHANGE COLUMN `blood_pressure_systolic` `blood_pressure_systolic` DOUBLE NULL DEFAULT NULL AFTER `temperature`,
            CHANGE COLUMN `blood_pressure_diastolic` `blood_pressure_diastolic` DOUBLE NULL DEFAULT NULL AFTER `blood_pressure_systolic`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180830_182228_medicine_doubles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_182228_medicine_doubles cannot be reverted.\n";

        return false;
    }
    */
}
