<?php

use yii\db\Migration;

/**
 * Class m180724_144238_add_blood_type_relation
 */
class m180724_144238_add_blood_type_relation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE `staff`
            ADD COLUMN `blood_type_id` INT(11) NULL DEFAULT NULL AFTER `team_id`;
        ');
        $this->execute('ALTER TABLE `staff`
            ADD CONSTRAINT `FK_staff_blood_type` FOREIGN KEY (`blood_type_id`) REFERENCES `blood_type` (`id`);
        ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180724_144238_add_blood_type_relation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180724_144238_add_blood_type_relation cannot be reverted.\n";

        return false;
    }
    */
}
