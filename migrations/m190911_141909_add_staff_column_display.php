<?php

use yii\db\Migration;

/**
 * Class m190911_141909_add_staff_column_display
 */
class m190911_141909_add_staff_column_display extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE `staff_column_display` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `sid` TINYINT(1) NOT NULL DEFAULT '1',
            `name` TINYINT(1) NOT NULL DEFAULT '1',
            `gender` TINYINT(1) NOT NULL DEFAULT '0',
            `date_of_birth` TINYINT(1) NOT NULL DEFAULT '0',
            `height` TINYINT(1) NOT NULL DEFAULT '0',
            `eye_color` TINYINT(1) NOT NULL DEFAULT '0',
            `profession` TINYINT(1) NOT NULL DEFAULT '0',
            `blood_type` TINYINT(1) NOT NULL DEFAULT '0',
            `team` TINYINT(1) NOT NULL DEFAULT '1',
            `special_function` TINYINT(1) NOT NULL DEFAULT '1',
            `section` TINYINT(1) NOT NULL DEFAULT '0',
            `department` TINYINT(1) NOT NULL DEFAULT '1',
            `citizenship` TINYINT(1) NOT NULL DEFAULT '0',
            `rank` TINYINT(1) NOT NULL DEFAULT '1',
            `registered` TINYINT(1) NOT NULL DEFAULT '0',
            `resistance_cell` TINYINT(1) NOT NULL DEFAULT '0',
            `callsign` TINYINT(1) NOT NULL DEFAULT '1',
            `status_alive` TINYINT(1) NOT NULL DEFAULT '0',
            `staff_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin',
            PRIMARY KEY (`id`),
            INDEX `FK_staff_column_display_staff` (`staff_sid`),
            CONSTRAINT `FK_staff_column_display_staff` FOREIGN KEY (`staff_sid`) REFERENCES `staff` (`sid`)
        );
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190911_141909_add_staff_column_display cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190911_141909_add_staff_column_display cannot be reverted.\n";

        return false;
    }
    */
}
