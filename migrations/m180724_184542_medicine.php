<?php

use yii\db\Migration;

/**
 * Class m180724_184542_medicine
 */
class m180724_184542_medicine extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE `medicine_checkup` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `author_rpn` VARCHAR(8) NOT NULL COLLATE 'utf8_bin',
            `patient_rpn` VARCHAR(8) NOT NULL COLLATE 'utf8_bin',
            `impairment` TEXT NULL COLLATE 'utf8_bin',
            `aftercare` TEXT NULL COLLATE 'utf8_bin',
            `breathing` ENUM('Unauffällig','Auffällig') NOT NULL COLLATE 'utf8_bin',
            `breathing_details` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_bin',
            `pupils` ENUM('Normal','Eng','Erweitert') NOT NULL COLLATE 'utf8_bin',
            `pulse` INT(11) NULL DEFAULT NULL,
            `temperature` INT(11) NULL DEFAULT NULL,
            `blood_pressure_systolic` INT(11) NULL DEFAULT NULL,
            `blood_pressure_diastolic` INT(11) NULL DEFAULT NULL,
            `nutrition` ENUM('Unauffällig','Unterernährt','Vitaminmangel') NOT NULL COLLATE 'utf8_bin',
            `psyche` ENUM('Unauffällig','Nicht beurteilbar','Psychiater informiert') NOT NULL COLLATE 'utf8_bin',
            `complexion` TEXT NOT NULL COLLATE 'utf8_bin',
            `vaccinations` TEXT NOT NULL COLLATE 'utf8_bin',
            `conditions` TEXT NOT NULL COLLATE 'utf8_bin',
            `drug_use` TEXT NOT NULL COLLATE 'utf8_bin',
            `other` TEXT NOT NULL COLLATE 'utf8_bin',
            `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `FK_medicine_checkup_author` (`author_rpn`),
            INDEX `FK_medicine_checkup_patient` (`patient_rpn`),
            CONSTRAINT `FK_medicine_checkup_author` FOREIGN KEY (`author_rpn`) REFERENCES `staff` (`rpn`),
            CONSTRAINT `FK_medicine_checkup_patient` FOREIGN KEY (`patient_rpn`) REFERENCES `staff` (`rpn`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ");
        $this->execute("
        CREATE TABLE `medicine_treatment` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `author_rpn` VARCHAR(8) NOT NULL COLLATE 'utf8_bin',
            `patient_rpn` VARCHAR(8) NOT NULL COLLATE 'utf8_bin',
            `impairment` TEXT NULL COLLATE 'utf8_bin',
            `aftercare` TEXT NULL COLLATE 'utf8_bin',
            `operational_fitness` ENUM('tauglich','eingeschränkt tauglich','gesperrt') NULL DEFAULT NULL COLLATE 'utf8_bin',
            `breathing` ENUM('Unauffällig','Auffällig') NOT NULL COLLATE 'utf8_bin',
            `breathing_details` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_bin',
            `pupils` ENUM('Normal','Eng','Erweitert') NOT NULL COLLATE 'utf8_bin',
            `pulse` INT(11) NULL DEFAULT NULL,
            `temperature` INT(11) NULL DEFAULT NULL,
            `blood_pressure_systolic` INT(11) NULL DEFAULT NULL,
            `blood_pressure_diastolic` INT(11) NULL DEFAULT NULL,
            `psyche` ENUM('Unauffällig','Nicht beurteilbar','Psychiater informiert') NOT NULL COLLATE 'utf8_bin',
            `pretreatment` ENUM('Keine','CM','FM') NOT NULL COLLATE 'utf8_bin',
            `medi_foam` ENUM('Kein','MK 1','MK 2','Injektor') NOT NULL COLLATE 'utf8_bin',
            `annotation` TEXT NOT NULL COLLATE 'utf8_bin',
            `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `FK_medicine_treatment_author` (`author_rpn`),
            INDEX `FK_medicine_treatment_patient` (`patient_rpn`),
            CONSTRAINT `FK_medicine_treatment_author` FOREIGN KEY (`author_rpn`) REFERENCES `staff` (`rpn`),
            CONSTRAINT `FK_medicine_treatment_patient` FOREIGN KEY (`patient_rpn`) REFERENCES `staff` (`rpn`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ");
        $this->execute("
        CREATE TABLE `medicine_checkup_injury` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `checkup_id` INT(11) NOT NULL,
            `x` DOUBLE NOT NULL,
            `y` DOUBLE NOT NULL,
            `injury` ENUM('Durchschuss','Steckschuss','Splitter','Verbrennung','Schnitt','Sonstiges') NOT NULL COLLATE 'utf8_bin',
            `annotation` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_bin',
            PRIMARY KEY (`id`),
            INDEX `FK_medicine_checkup_injury_medicine_checkup` (`checkup_id`),
            CONSTRAINT `FK_medicine_checkup_injury_medicine_checkup` FOREIGN KEY (`checkup_id`) REFERENCES `medicine_checkup` (`id`)
        )
        COLLATE='utf8_bin'
        ;
        ");
        $this->execute("
        CREATE TABLE `medicine_treatment_injury` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `treatment_id` INT(11) NOT NULL,
            `x` DOUBLE NOT NULL,
            `y` DOUBLE NOT NULL,
            `injury` ENUM('Durchschuss','Steckschuss','Splitter','Verbrennung','Schnitt','Sonstiges') NOT NULL COLLATE 'utf8_bin',
            `operation` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_bin',
            `annotation` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_bin',
            PRIMARY KEY (`id`),
            INDEX `FK_medicine_treatment_injury_medicine_treatment` (`treatment_id`),
            CONSTRAINT `FK_medicine_treatment_injury_medicine_treatment` FOREIGN KEY (`treatment_id`) REFERENCES `medicine_treatment` (`id`)
        )
        COLLATE='utf8_bin'
        ;
        ");
        $this->execute("
                CREATE TABLE `medicine_drug` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(128) NOT NULL COLLATE 'utf8_bin',
            `order` INT(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ;
        ");
        $this->execute("
        INSERT INTO `medicine_drug` (`id`, `name`, `order`) VALUES (1, 'Adrenalin', 1);
        INSERT INTO `medicine_drug` (`id`, `name`, `order`) VALUES (2, 'Schmerzmittel', 2);
        ");
        $this->execute("
        CREATE TABLE `medicine_treatment_medication` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `treatment_id` INT(11) NOT NULL,
            `location` ENUM('Stationär','Im Feld') NOT NULL COLLATE 'utf8_bin',
            `drug_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`),
            INDEX `FK_medicine_treatment_medication_medicine_drug` (`drug_id`),
            INDEX `FK_medicine_treatment_medication_medicine_treatment` (`treatment_id`),
            CONSTRAINT `FK_medicine_treatment_medication_medicine_drug` FOREIGN KEY (`drug_id`) REFERENCES `medicine_drug` (`id`),
            CONSTRAINT `FK_medicine_treatment_medication_medicine_treatment` FOREIGN KEY (`treatment_id`) REFERENCES `medicine_treatment` (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180724_184542_medicine cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180724_184542_medicine cannot be reverted.\n";

        return false;
    }
    */
}
