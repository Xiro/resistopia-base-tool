<?php

use yii\db\Migration;

class m170910_130917_structure extends Migration
{
    public function safeUp()
    {
        $this->execute("CREATE TABLE `company` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `category` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `speciality` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `rank` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `team` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `blood_type` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `eye_color` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `role` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");

        $this->execute("CREATE TABLE `staff` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `rpn` VARCHAR(10) NOT NULL,
            `forename` VARCHAR(50) NOT NULL,
            `surname` VARCHAR(50) NULL DEFAULT NULL,
            `nickname` VARCHAR(50) NULL DEFAULT NULL,
            `height` INT NULL DEFAULT NULL COMMENT 'in cm',
            `profession` VARCHAR(50) NULL DEFAULT NULL,
            `call_sign` VARCHAR(4) NULL DEFAULT NULL,
            `is_blocked` ENUM('Yes','No') NOT NULL DEFAULT 'No',
            `is_it` ENUM('Yes','No') NOT NULL DEFAULT 'Yes',
            `company_id` INT NULL,
            `category_id` INT NULL,
            `speciality_id` INT NULL,
            `rank_id` INT NOT NULL,
            `team_id` INT NULL,
            `blood_type_id` INT NULL,
            `eye_color_id` INT NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `rpn` (`rpn`),
            UNIQUE INDEX `call_sign` (`call_sign`),
            CONSTRAINT `FK_staff_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
            CONSTRAINT `FK_staff_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
            CONSTRAINT `FK_staff_speciality` FOREIGN KEY (`speciality_id`) REFERENCES `speciality` (`id`),
            CONSTRAINT `FK_staff_rank` FOREIGN KEY (`rank_id`) REFERENCES `rank` (`id`),
            CONSTRAINT `FK_staff_team` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`),
            CONSTRAINT `FK_staff_blood_type` FOREIGN KEY (`blood_type_id`) REFERENCES `blood_type` (`id`),
            CONSTRAINT `FK_staff_eye_color` FOREIGN KEY (`eye_color_id`) REFERENCES `eye_color` (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ");

        $this->execute("CREATE TABLE `staff_role` (
            `staff_id` INT NOT NULL,
            `role_id` INT NOT NULL,
            UNIQUE INDEX `staff_id` (`staff_id`, `role_id`),
            CONSTRAINT `FK_staff_role_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
            CONSTRAINT `FK_staff_role_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ");

        $this->execute("CREATE TABLE `status` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");

        $this->execute("ALTER TABLE `staff`
            ADD COLUMN `status_id` INT(11) NOT NULL AFTER `eye_color_id`,
            ADD CONSTRAINT `FK_staff_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);");


        $this->execute("CREATE TABLE `operation` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `mission_type` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `mission_call` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL,
            `description` TEXT NULL DEFAULT NULL,
            `RP` TINYINT NOT NULL,
            `FP` TINYINT NOT NULL,
            `zone` ENUM('1','2','3') NOT NULL,
            `due` DATETIME NOT NULL,
            `max_duration` TIME NOT NULL,
            `fighter` SMALLINT NOT NULL DEFAULT '0',
            `radio` TINYINT NOT NULL DEFAULT '0',
            `medic` TINYINT NOT NULL DEFAULT '0',
            `technician` TINYINT NOT NULL DEFAULT '0',
            `science` TINYINT NOT NULL DEFAULT '0',
            `guard` TINYINT NOT NULL DEFAULT '0',
            `vip` TINYINT NOT NULL DEFAULT '0',
            `mission_type_id` INT NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            CONSTRAINT `FK_mission_call_mission_type` FOREIGN KEY (`mission_type_id`) REFERENCES `mission_type` (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ");
        $this->execute("CREATE TABLE `mission_status` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_bin',
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;");
        $this->execute("CREATE TABLE `mission` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL,
            `description` TEXT NULL,
            `RP` TINYINT NOT NULL,
            `FP` TINYINT NOT NULL,
            `zone` ENUM('1','2','3') NOT NULL,
            `started` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `ended` DATETIME NULL,
            `debrief_comment` TEXT NULL,
            `mission_type_id` INT NOT NULL,
            `mission_status_id` INT NOT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `FK__mission_type` FOREIGN KEY (`mission_type_id`) REFERENCES `mission_type` (`id`),
            CONSTRAINT `FK__mission_status` FOREIGN KEY (`mission_status_id`) REFERENCES `mission_status` (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ");
        $this->execute("ALTER TABLE `staff`
	      CHANGE COLUMN `status_id` `staff_status_id` INT(11) NOT NULL AFTER `eye_color_id`;");
        $this->execute("RENAME TABLE `status` TO `staff_status`;");
        $this->execute("ALTER TABLE `staff`
            DROP FOREIGN KEY `FK_staff_status`;
            ALTER TABLE `staff`
            ADD CONSTRAINT `FK_staff_staff_status` FOREIGN KEY (`staff_status_id`) REFERENCES `staff_status` (`id`);");
        $this->execute("ALTER TABLE `staff`
            ADD COLUMN `password` VARCHAR(50) NULL DEFAULT NULL AFTER `profession`,
            ADD COLUMN `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `password`,
            ADD COLUMN `updated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created`,
            ADD COLUMN `died` DATETIME NULL DEFAULT NULL AFTER `updated`;
        ");

        $this->execute("ALTER TABLE `category`
	        ADD UNIQUE INDEX `name` (`name`);");
        $this->execute("ALTER TABLE `company`
	        ADD UNIQUE INDEX `name` (`name`);");
        $this->execute("ALTER TABLE `eye_color`
	        ADD UNIQUE INDEX `name` (`name`);");
        $this->execute("ALTER TABLE `rank`
	        ADD UNIQUE INDEX `name` (`name`);");
        $this->execute("ALTER TABLE `role`
	        ADD UNIQUE INDEX `name` (`name`);");
        $this->execute("ALTER TABLE `speciality`
	        ADD UNIQUE INDEX `name` (`name`);");
        $this->execute("ALTER TABLE `staff_status`
	        ADD UNIQUE INDEX `name` (`name`);");
        $this->execute("ALTER TABLE `team`
	        ADD UNIQUE INDEX `name` (`name`);");
    }

    public function safeDown()
    {
        echo "m170910_130917_structure cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170910_130917_structure cannot be reverted.\n";

        return false;
    }
    */
}
