<?php

use yii\db\Migration;

/**
 * Class m190830_133047_rpn_to_sid
 */
class m190830_133047_rpn_to_sid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `staff`
            ALTER `rpn` DROP DEFAULT;
        ALTER TABLE `staff`
            CHANGE COLUMN `rpn` `sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' FIRST,
            DROP INDEX `rpn`,
            ADD UNIQUE INDEX `rpn` (`sid`);
        ALTER TABLE `staff`
            DROP INDEX `rpn`,
            ADD UNIQUE INDEX `sid` (`sid`);

        ALTER TABLE `mission`
            ALTER `created_by_rpn` DROP DEFAULT;
        ALTER TABLE `mission`
            CHANGE COLUMN `created_by_rpn` `created_by_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `mission_type_id`,
            CHANGE COLUMN `mission_lead_rpn` `mission_lead_sid` VARCHAR(8) NULL DEFAULT NULL COLLATE 'utf8_bin' AFTER `created_by_sid`;

        ALTER TABLE `staff_file_memo`
            ALTER `rpn` DROP DEFAULT,
            ALTER `author_rpn` DROP DEFAULT;
        ALTER TABLE `staff_file_memo`
            CHANGE COLUMN `rpn` `sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `access_right_id`,
            CHANGE COLUMN `author_rpn` `author_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `sid`;

        ALTER TABLE `medi_foam_distribution`
            ALTER `recipient_rpn` DROP DEFAULT,
            ALTER `issued_by_rpn` DROP DEFAULT;
        ALTER TABLE `medi_foam_distribution`
            CHANGE COLUMN `recipient_rpn` `recipient_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `id`,
            CHANGE COLUMN `issued_by_rpn` `issued_by_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `recipient_sid`;

        ALTER TABLE `medicine_treatment`
            ALTER `author_rpn` DROP DEFAULT,
            ALTER `patient_rpn` DROP DEFAULT;
        ALTER TABLE `medicine_treatment`
            CHANGE COLUMN `author_rpn` `author_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `id`,
            CHANGE COLUMN `patient_rpn` `patient_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `author_sid`;

        ALTER TABLE `user`
            CHANGE COLUMN `rpn` `sid` VARCHAR(8) NULL DEFAULT NULL COLLATE 'utf8_bin' AFTER `id`;

        ALTER TABLE `staff_background`
            ALTER `rpn` DROP DEFAULT;
        ALTER TABLE `staff_background`
            CHANGE COLUMN `rpn` `sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `id`;

        ALTER TABLE `mission_block`
            ALTER `blocked_staff_member_rpn` DROP DEFAULT,
            ALTER `blocked_by_rpn` DROP DEFAULT;
        ALTER TABLE `mission_block`
            CHANGE COLUMN `blocked_staff_member_rpn` `blocked_staff_member_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `id`,
            CHANGE COLUMN `blocked_by_rpn` `blocked_by_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `blocked_staff_member_sid`;

        ALTER TABLE `mission_status_history`
            CHANGE COLUMN `author_rpn` `author_sid` VARCHAR(8) NULL DEFAULT NULL COLLATE 'utf8_bin' AFTER `mission_status_id`;

        ALTER TABLE `medicine_checkup`
            ALTER `author_rpn` DROP DEFAULT,
            ALTER `patient_rpn` DROP DEFAULT;
        ALTER TABLE `medicine_checkup`
            CHANGE COLUMN `author_rpn` `author_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `id`,
            CHANGE COLUMN `patient_rpn` `patient_sid` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `author_sid`;

        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190830_133047_rpn_to_sid cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190830_133047_rpn_to_sid cannot be reverted.\n";

        return false;
    }
    */
}
