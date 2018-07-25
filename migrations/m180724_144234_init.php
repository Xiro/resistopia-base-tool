<?php

use yii\db\Migration;

/**
 * Class m180724_144234_init
 */
class m180724_144234_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('
        -- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.1.13-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=\'NO_AUTO_VALUE_ON_ZERO\' */;


-- Exportiere Struktur von Tabelle cic_new.access_category
CREATE TABLE IF NOT EXISTS `access_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.access_key
CREATE TABLE IF NOT EXISTS `access_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'Binary number which represents access rights of a user or staff member\';

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.access_key_mask
CREATE TABLE IF NOT EXISTS `access_key_mask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_mask_id` int(11) NOT NULL,
  `access_key_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_access_key_mask_access_mask` (`access_mask_id`),
  KEY `FK_access_key_mask_access_key` (`access_key_id`),
  CONSTRAINT `FK_access_key_mask_access_key` FOREIGN KEY (`access_key_id`) REFERENCES `access_key` (`id`),
  CONSTRAINT `FK_access_key_mask_access_mask` FOREIGN KEY (`access_mask_id`) REFERENCES `access_mask` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.access_key_right
CREATE TABLE IF NOT EXISTS `access_key_right` (
  `access_key_id` int(11) NOT NULL,
  `access_right_id` int(11) NOT NULL,
  KEY `FK_access_key_right_access_key` (`access_key_id`),
  KEY `FK_access_key_right_access_right` (`access_right_id`),
  CONSTRAINT `FK_access_key_right_access_key` FOREIGN KEY (`access_key_id`) REFERENCES `access_key` (`id`),
  CONSTRAINT `FK_access_key_right_access_right` FOREIGN KEY (`access_right_id`) REFERENCES `access_right` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.access_mask
CREATE TABLE IF NOT EXISTS `access_mask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `protected` tinyint(1) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'binary number containing representations of multiple access rights, which can be added to an access_key\';

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.access_mask_right
CREATE TABLE IF NOT EXISTS `access_mask_right` (
  `access_mask_id` int(11) NOT NULL,
  `access_right_id` int(11) NOT NULL,
  KEY `FK_access_mask_rights_access_mask` (`access_mask_id`),
  KEY `FK_access_mask_rights_access_right` (`access_right_id`),
  CONSTRAINT `FK_access_mask_rights_access_mask` FOREIGN KEY (`access_mask_id`) REFERENCES `access_mask` (`id`),
  CONSTRAINT `FK_access_mask_rights_access_right` FOREIGN KEY (`access_right_id`) REFERENCES `access_right` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.access_right
CREATE TABLE IF NOT EXISTS `access_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin,
  `order` int(11) NOT NULL DEFAULT \'0\',
  `access_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `FK_access_bit_access_category` (`access_category_id`),
  CONSTRAINT `FK_access_bit_access_category` FOREIGN KEY (`access_category_id`) REFERENCES `access_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'Single access right, described by title and category\';

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.access_security_area
CREATE TABLE IF NOT EXISTS `access_security_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `access_right_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_security_access_area_access_right` (`access_right_id`),
  CONSTRAINT `FK_security_access_area_access_right` FOREIGN KEY (`access_right_id`) REFERENCES `access_right` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.base_category
CREATE TABLE IF NOT EXISTS `base_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `access_mask_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_base_category_access_mask` (`access_mask_id`),
  CONSTRAINT `FK_base_category_access_mask` FOREIGN KEY (`access_mask_id`) REFERENCES `access_mask` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.blood_type
CREATE TABLE IF NOT EXISTS `blood_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.citizenship
CREATE TABLE IF NOT EXISTS `citizenship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.company
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.eye_color
CREATE TABLE IF NOT EXISTS `eye_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.mission
CREATE TABLE IF NOT EXISTS `mission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `debrief_comment` text COLLATE utf8_bin,
  `note` text COLLATE utf8_bin,
  `zone` enum(\'1\',\'2\',\'3\') COLLATE utf8_bin NOT NULL,
  `slots_total` int(11) DEFAULT NULL,
  `slots_medic` int(11) DEFAULT NULL,
  `slots_radio` int(11) DEFAULT NULL,
  `slots_tech` int(11) DEFAULT NULL,
  `slots_res` int(11) DEFAULT NULL,
  `slots_guard` int(11) DEFAULT NULL,
  `slots_vip` int(11) DEFAULT NULL,
  `mission_status_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `mission_type_id` int(11) NOT NULL,
  `created_by_rpn` varchar(8) COLLATE utf8_bin NOT NULL,
  `mission_lead_rpn` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `time_publish` datetime DEFAULT CURRENT_TIMESTAMP,
  `time_lst` datetime DEFAULT NULL COMMENT \'Limit of Start Time\',
  `time_ete` datetime DEFAULT NULL COMMENT \'Estimared Time of Execution\',
  `time_atf` time DEFAULT NULL COMMENT \'Accepted Time Favor\',
  `finished` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_mission_staff` (`created_by_rpn`),
  KEY `FK_mission_mission_type` (`mission_type_id`),
  KEY `FK_mission_operation` (`operation_id`),
  KEY `FK_mission_staff_2` (`mission_lead_rpn`),
  KEY `FK_mission_mission_status` (`mission_status_id`),
  CONSTRAINT `FK_mission_mission_status` FOREIGN KEY (`mission_status_id`) REFERENCES `mission_status` (`id`),
  CONSTRAINT `FK_mission_mission_type` FOREIGN KEY (`mission_type_id`) REFERENCES `mission_type` (`id`),
  CONSTRAINT `FK_mission_operation` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`),
  CONSTRAINT `FK_mission_staff` FOREIGN KEY (`created_by_rpn`) REFERENCES `staff` (`rpn`),
  CONSTRAINT `FK_mission_staff_2` FOREIGN KEY (`mission_lead_rpn`) REFERENCES `staff` (`rpn`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.mission_block
CREATE TABLE IF NOT EXISTS `mission_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blocked_staff_member_rpn` varchar(8) COLLATE utf8_bin NOT NULL,
  `blocked_by_rpn` varchar(8) COLLATE utf8_bin NOT NULL,
  `unblock_time` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_mission_block_staff` (`blocked_staff_member_rpn`),
  KEY `FK_mission_block_staff_2` (`blocked_by_rpn`),
  CONSTRAINT `FK_mission_block_staff` FOREIGN KEY (`blocked_staff_member_rpn`) REFERENCES `staff` (`rpn`),
  CONSTRAINT `FK_mission_block_staff_2` FOREIGN KEY (`blocked_by_rpn`) REFERENCES `staff` (`rpn`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.mission_staff
CREATE TABLE IF NOT EXISTS `mission_staff` (
  `mission_id` int(11) NOT NULL,
  `staff_rpn` varchar(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`mission_id`,`staff_rpn`),
  UNIQUE KEY `mission_id_staff_rpn` (`mission_id`,`staff_rpn`),
  KEY `FK_mission_staff_staff` (`staff_rpn`),
  CONSTRAINT `FK_mission_staff_mission` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`),
  CONSTRAINT `FK_mission_staff_staff` FOREIGN KEY (`staff_rpn`) REFERENCES `staff` (`rpn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.mission_status
CREATE TABLE IF NOT EXISTS `mission_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.mission_status_history
CREATE TABLE IF NOT EXISTS `mission_status_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mission_id` int(11) NOT NULL,
  `mission_status_id` int(11) NOT NULL,
  `author_rpn` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_mission_status_history_mission` (`mission_id`),
  KEY `FK_mission_status_history_mission_status` (`mission_status_id`),
  KEY `FK_mission_status_history_staff` (`author_rpn`),
  CONSTRAINT `FK_mission_status_history_mission` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`),
  CONSTRAINT `FK_mission_status_history_mission_status` FOREIGN KEY (`mission_status_id`) REFERENCES `mission_status` (`id`),
  CONSTRAINT `FK_mission_status_history_staff` FOREIGN KEY (`author_rpn`) REFERENCES `staff` (`rpn`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.mission_type
CREATE TABLE IF NOT EXISTS `mission_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.operation
CREATE TABLE IF NOT EXISTS `operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.rank
CREATE TABLE IF NOT EXISTS `rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `short_name` varchar(12) COLLATE utf8_bin NOT NULL,
  `access_mask_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rank_access_mask` (`access_mask_id`),
  CONSTRAINT `FK_rank_access_mask` FOREIGN KEY (`access_mask_id`) REFERENCES `access_mask` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.special_function
CREATE TABLE IF NOT EXISTS `special_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `short_name` varchar(4) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `rpn` varchar(8) COLLATE utf8_bin NOT NULL,
  `forename` varchar(128) COLLATE utf8_bin NOT NULL,
  `surname` varchar(128) COLLATE utf8_bin NOT NULL,
  `nickname` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `gender` enum(\'m\',\'f\') COLLATE utf8_bin NOT NULL,
  `date_of_birth` date NOT NULL,
  `profession` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `callsign` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `height` int(3) DEFAULT NULL,
  `status_it` tinyint(1) NOT NULL DEFAULT \'1\',
  `status_be13` tinyint(1) NOT NULL DEFAULT \'1\',
  `status_alive` tinyint(1) NOT NULL DEFAULT \'1\',
  `status_in_base` tinyint(1) NOT NULL DEFAULT \'1\',
  `squat_number` int(2) DEFAULT NULL,
  `access_key_id` int(11) DEFAULT NULL,
  `rank_id` int(11) NOT NULL,
  `base_category_id` int(11) DEFAULT NULL,
  `special_function_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `citizenship_id` int(11) DEFAULT NULL,
  `eye_color_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rpn`),
  UNIQUE KEY `rpn` (`rpn`),
  KEY `FK_staff_rank` (`rank_id`),
  KEY `FK_staff_base_category` (`base_category_id`),
  KEY `FK_staff_special_category` (`special_function_id`),
  KEY `FK_staff_eye_color` (`eye_color_id`),
  KEY `FK_staff_company` (`company_id`),
  KEY `FK_staff_citizenship` (`citizenship_id`),
  KEY `FK_staff_team` (`team_id`),
  KEY `FK_staff_access_key` (`access_key_id`),
  CONSTRAINT `FK_staff_access_key` FOREIGN KEY (`access_key_id`) REFERENCES `access_key` (`id`),
  CONSTRAINT `FK_staff_base_category` FOREIGN KEY (`base_category_id`) REFERENCES `base_category` (`id`),
  CONSTRAINT `FK_staff_citizenship` FOREIGN KEY (`citizenship_id`) REFERENCES `citizenship` (`id`),
  CONSTRAINT `FK_staff_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_staff_eye_color` FOREIGN KEY (`eye_color_id`) REFERENCES `eye_color` (`id`),
  CONSTRAINT `FK_staff_rank` FOREIGN KEY (`rank_id`) REFERENCES `rank` (`id`),
  CONSTRAINT `FK_staff_special_category` FOREIGN KEY (`special_function_id`) REFERENCES `special_function` (`id`),
  CONSTRAINT `FK_staff_team` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.staff_background
CREATE TABLE IF NOT EXISTS `staff_background` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rpn` varchar(8) COLLATE utf8_bin NOT NULL,
  `story_before` longtext COLLATE utf8_bin,
  `story_during` longtext COLLATE utf8_bin,
  `story_after` longtext COLLATE utf8_bin,
  `career` longtext COLLATE utf8_bin,
  `characteristics` longtext COLLATE utf8_bin,
  `personality` longtext COLLATE utf8_bin,
  `awards` longtext COLLATE utf8_bin,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rpn` (`rpn`),
  CONSTRAINT `FK_staff_background_staff` FOREIGN KEY (`rpn`) REFERENCES `staff` (`rpn`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.staff_file_memo
CREATE TABLE IF NOT EXISTS `staff_file_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `file_memo` text COLLATE utf8_bin NOT NULL,
  `access_right_id` int(11) DEFAULT NULL,
  `rpn` varchar(8) COLLATE utf8_bin NOT NULL,
  `author_rpn` varchar(8) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_staff_file_memo_staff` (`author_rpn`),
  KEY `FK_staff_file_memo_author` (`rpn`),
  KEY `FK_staff_file_memo_access_bit` (`access_right_id`),
  CONSTRAINT `FK_staff_file_memo_access_bit` FOREIGN KEY (`access_right_id`) REFERENCES `access_right` (`id`),
  CONSTRAINT `FK_staff_file_memo_author` FOREIGN KEY (`rpn`) REFERENCES `staff` (`rpn`),
  CONSTRAINT `FK_staff_file_memo_staff` FOREIGN KEY (`author_rpn`) REFERENCES `staff` (`rpn`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.team
CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `comment` text COLLATE utf8_bin,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle cic_new.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rpn` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_bin NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_bin NOT NULL,
  `access_key_id` int(11) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT \'0\',
  `is_admin` tinyint(1) NOT NULL DEFAULT \'0\',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_key` (`auth_key`),
  UNIQUE KEY `rpn` (`rpn`),
  KEY `FK_user_access_key` (`access_key_id`),
  CONSTRAINT `FK_user_access_key` FOREIGN KEY (`access_key_id`) REFERENCES `access_key` (`id`),
  CONSTRAINT `FK_user_staff` FOREIGN KEY (`rpn`) REFERENCES `staff` (`rpn`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Daten Export vom Benutzer nicht ausgewählt
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, \'\') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

        ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180724_144234_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180724_144234_init cannot be reverted.\n";

        return false;
    }
    */
}
