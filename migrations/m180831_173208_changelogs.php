<?php

use yii\db\Migration;

class m180831_173208_changelogs extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    private $table = '{{%changelogs}}';

    public function safeUp()
    {
        $this->execute("CREATE TABLE `changelog` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `object` VARCHAR(191) NOT NULL,
            `primary_key` VARCHAR(50) NOT NULL,
            `data` TEXT NULL,
            `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `type` VARCHAR(191) NULL DEFAULT NULL,
            `user_id` INT(11) NULL DEFAULT NULL,
            `hostname` VARCHAR(191) NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            INDEX `IN_related_object_type` (`object`),
            INDEX `IN_related_object_id` (`primary_key`),
            INDEX `IN_type` (`type`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ");
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
