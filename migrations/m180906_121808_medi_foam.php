<?php

use yii\db\Migration;

/**
 * Class m180906_121808_medi_foam
 */
class m180906_121808_medi_foam extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `medi_foam_distribution` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `receiver_rpn` VARCHAR(7) NOT NULL,
            `issued_by_rpn` VARCHAR(7) NOT NULL,
            `mk1_issued` INT NOT NULL DEFAULT '0',
            `mk1_returned` INT NOT NULL DEFAULT '0',
            `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ALTER TABLE `medi_foam_distribution`
            ALTER `receiver_rpn` DROP DEFAULT,
            ALTER `issued_by_rpn` DROP DEFAULT;
        ALTER TABLE `medi_foam_distribution`
            CHANGE COLUMN `receiver_rpn` `receiver_rpn` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `id`,
            CHANGE COLUMN `issued_by_rpn` `issued_by_rpn` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `receiver_rpn`,
            ADD CONSTRAINT `FK_medi_foam_distribution_staff` FOREIGN KEY (`receiver_rpn`) REFERENCES `staff` (`rpn`),
            ADD CONSTRAINT `FK_medi_foam_distribution_staff_2` FOREIGN KEY (`issued_by_rpn`) REFERENCES `staff` (`rpn`);
        ALTER TABLE `medi_foam_distribution`
        	CHANGE COLUMN `receiver_rpn` `recipient_rpn` VARCHAR(8) NOT NULL COLLATE 'utf8_bin' AFTER `id`;
        ");
        $this->execute("
        INSERT INTO `cic_migration_test`.`access_category` (`name`, `order`) VALUES ('Medi Foam Distribution', '23');
        ");
        /** @var \app\models\AccessCategory $category */
        $category = \app\models\AccessCategory::findOne(['name' => 'Medi Foam Distribution']);
        $this->execute("
            INSERT INTO `cic_migration_test`.`access_right` (`key`, `name`, `order`, `access_category_id`) VALUES ('medi-foam-distribution/view', 'View Medi Foam Distribution', '101', :categoryId);
            INSERT INTO `cic_migration_test`.`access_right` (`key`, `name`, `order`, `access_category_id`) VALUES ('medi-foam-distribution/create', 'View Medi Foam Distribution', '101', :categoryId);
            INSERT INTO `cic_migration_test`.`access_right` (`key`, `name`, `order`, `access_category_id`) VALUES ('medi-foam-distribution/update', 'View Medi Foam Distribution', '101', :categoryId);
            INSERT INTO `cic_migration_test`.`access_right` (`key`, `name`, `order`, `access_category_id`) VALUES ('medi-foam-distribution/delete', 'View Medi Foam Distribution', '101', :categoryId);
        ", [
            'categoryId' => $category->id
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180906_121808_medi_foam cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_121808_medi_foam cannot be reverted.\n";

        return false;
    }
    */
}
