<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\AccessKey;
use app\models\BaseCategory;
use app\models\BloodType;
use app\models\Citizenship;
use app\models\Company;
use app\models\EyeColor;
use app\models\forms\StaffForm;
use app\models\Rank;
use app\models\SpecialFunction;
use app\models\Staff;
use app\models\Team;
use Yii;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class DbMigrateController extends Controller
{

    public $verbose;

    public static $associationParams = [
        "special_category" => [
            "tbl_specialcategory",
            "Specialcategory",
            "SpecialcategoryID",
            "special_function",
            "special_function_id",
            SpecialFunction::class,
            null
        ],
        "rank"             => [
            "tbl_rank",
            "Rank",
            "RankID",
            "rank",
            "rank_id",
            Rank::class,
            null
        ],
        "base_category"    => [
            "tbl_basecategory",
            "Basecategory",
            "BasecategoryID",
            "base_category",
            "base_category_id",
            BaseCategory::class,
            null
        ],
        "eye_color"        => [
            "tbl_eyecolor",
            "Eyecolor",
            "EyecolorID",
            "eye_color",
            "eye_color_id",
            EyeColor::class,
            null
        ],
        "blood_type"       => [
            "tbl_bloodtype",
            "Bloodtype",
            "BloodtypeID",
            "blood_type",
            "blood_type_id",
            BloodType::class,
            null
        ],
        "citizenship"      => [
            "",
            "",
            "",
            "citizenship",
            "citizenship_id",
            Citizenship::class,
            "
                SELECT resi_new.tbl_staff.Rpn as rpn, resi_new.tbl_staff.Citizenship as name FROM resi_new.tbl_staff;
                "
        ],
        "company"          => [
            "",
            "",
            "",
            "company",
            "company_id",
            Company::class,
            "
                SELECT resi_new.tbl_staff.Rpn as rpn, resi_new.tbl_staff.Company as name FROM resi_new.tbl_staff;
                "
        ],
        "team"             => [
            "",
            "",
            "",
            "team",
            "team_id",
            Team::class,
            "
                SELECT resi_new.tbl_staff.Rpn as rpn, resi_new.tbl_team.Name as name FROM resi_new.tbl_staff
                    LEFT JOIN resi_new.tbl_teamsquatstaffassigned ON resi_new.tbl_staff.Rpn = resi_new.tbl_teamsquatstaffassigned.RPN
                    LEFT JOIN resi_new.tbl_team ON resi_new.tbl_team.TeamID = resi_new.tbl_teamsquatstaffassigned.TeamID;
                "
        ],
    ];

    public function options($actionID)
    {
        return [
            'verbose'
        ];
    }

    /**
     * This command echoes what you have entered as the message.
     */
    public function actionMigrateFromResiNew()
    {
        echo "Migrating data from database resi_new\n";
        $this->execute("
        # del data
DELETE FROM mission_status;

DELETE FROM staff;
DELETE FROM special_function;
DELETE FROM company;
DELETE FROM citizenship;
DELETE FROM eye_color;
DELETE FROM team;
DELETE FROM blood_type;

# 
INSERT INTO eye_color (name) SELECT DISTINCT Name FROM resi_new.tbl_eyecolor WHERE Name != 'n/a';
INSERT INTO mission_status (name) SELECT DISTINCT Name FROM resi_new.tbl_missionstatus;
INSERT INTO special_function (name, short_name) SELECT DISTINCT Name, Shortname FROM resi_new.tbl_specialcategory WHERE Name != 'keine';
INSERT INTO mission_status (name) SELECT DISTINCT Name FROM resi_new.tbl_missionstatus;

# team
INSERT INTO team (name,description) SELECT DISTINCT Name,Description FROM resi_new.tbl_team WHERE Name != 'keins';

# blood_type
INSERT INTO blood_type (name) SELECT DISTINCT Name FROM resi_new.tbl_bloodtype WHERE Name != 'k.a.';

# citizenship
INSERT INTO citizenship (name) SELECT DISTINCT Citizenship FROM resi_new.tbl_staff WHERE Citizenship != '';

# company
INSERT INTO company (name) SELECT DISTINCT Company FROM resi_new.tbl_staff WHERE Company != '';

# staff
DROP PROCEDURE IF EXISTS staff2staff;
DELIMITER ;;

CREATE PROCEDURE staff2staff()
BEGIN
	DECLARE n INT DEFAULT 0;
	DECLARE i INT DEFAULT 0;

	DECLARE var_rank_name CHAR(255);
	DECLARE var_new_rank_id INT DEFAULT NULL;

	DECLARE var_base_category_name CHAR(255);
	DECLARE var_new_base_category_id INT DEFAULT NULL;

	DECLARE var_special_category_name CHAR(255);
	DECLARE var_new_special_function_id INT DEFAULT NULL;

	DECLARE var_company_name CHAR(255);
	DECLARE var_new_company_id INT DEFAULT NULL;

	DECLARE var_citizenship_name CHAR(255);
	DECLARE var_new_citizenship_id INT DEFAULT NULL;

	DECLARE var_eyecolor_name CHAR(255);
	DECLARE var_new_eyecolor_id INT DEFAULT NULL;

	DECLARE var_blood_type_name CHAR(255);
	DECLARE var_new_blood_type_id INT DEFAULT NULL;

	DECLARE var_team_name CHAR(255);
	DECLARE var_new_team_id INT DEFAULT NULL;

	DECLARE var_rpn VARCHAR(8);
	DECLARE var_forname VARCHAR(128);
	DECLARE var_surname VARCHAR(128);
	DECLARE var_nickname VARCHAR(128);
	DECLARE var_gender ENUM('m','f');
	DECLARE var_birthdate DATE;
	DECLARE var_profession VARCHAR(128);
	DECLARE var_callsign VARCHAR(128);
	DECLARE var_height int(3);
	DECLARE var_status_it tinyint;
	DECLARE var_status_be13 tinyint;
	DECLARE var_status_alive tinyint;
	DECLARE var_status_in_base tinyint;


	SELECT COUNT(*) FROM resi_new.tbl_staff INTO n;
	SET i=0;
	WHILE i<n DO
		# get new rank id
		SET var_new_rank_id = NULL;
		SET var_rank_name = NULL;
		SELECT resi_new.tbl_rank.Name FROM resi_new.tbl_staff LEFT JOIN resi_new.tbl_rank ON resi_new.tbl_rank.RankID = resi_new.tbl_staff.Rank LIMIT i,1 INTO var_rank_name;
		SELECT id FROM rank WHERE name = var_rank_name LIMIT 1 INTO var_new_rank_id;
		
		# get new base category id
		SET var_new_base_category_id = NULL;
		SET var_base_category_name = NULL;
		SELECT resi_new.tbl_basecategory.Name FROM resi_new.tbl_staff LEFT JOIN resi_new.tbl_basecategory ON resi_new.tbl_basecategory.BasecategoryID = resi_new.tbl_staff.Basecategory LIMIT i,1 INTO var_base_category_name;
		SELECT id FROM base_category WHERE name = var_base_category_name LIMIT 1 INTO var_new_base_category_id;
		
		# get new special function id
		SET var_new_special_function_id = NULL;
		SET var_special_category_name = NULL;
		SELECT resi_new.tbl_specialcategory.Name FROM resi_new.tbl_staff LEFT JOIN resi_new.tbl_specialcategory ON resi_new.tbl_specialcategory.SpecialcategoryID = resi_new.tbl_staff.Specialcategory LIMIT i,1 INTO var_special_category_name;
		SELECT id FROM special_function WHERE name = var_special_category_name LIMIT 1 INTO var_new_special_function_id;
		
		# get new eyecolor id
		SET var_new_eyecolor_id = NULL;
		SET var_eyecolor_name =NULL;
		SELECT resi_new.tbl_eyecolor.Name FROM resi_new.tbl_staff LEFT JOIN resi_new.tbl_eyecolor ON resi_new.tbl_eyecolor.EyecolorID = resi_new.tbl_staff.Eyecolor LIMIT i,1 INTO var_eyecolor_name;
		SELECT id FROM eye_color WHERE name = var_eyecolor_name LIMIT 1 INTO var_new_eyecolor_id;
		
		# get new blood type id
		SET var_new_blood_type_id = NULL;
		SET var_blood_type_name = NULL;
		SELECT resi_new.tbl_bloodtype.Name FROM resi_new.tbl_staff LEFT JOIN resi_new.tbl_bloodtype ON resi_new.tbl_bloodtype.BloodtypeID = resi_new.tbl_staff.Bloodtype LIMIT i,1 INTO var_blood_type_name;
		SELECT id FROM blood_type WHERE name = var_blood_type_name LIMIT 1 INTO var_new_blood_type_id;
		
		# get new company id
		SET var_new_company_id = NULL;
		SET var_company_name = NULL;
		SELECT resi_new.tbl_staff.Company FROM resi_new.tbl_staff LIMIT i,1 INTO var_company_name;
		SELECT id FROM company WHERE name = var_company_name LIMIT 1 INTO var_new_company_id;
		
		# get new citizenship id
		SET var_new_citizenship_id = NULL;
		SET var_citizenship_name = NULL;
		SELECT resi_new.tbl_staff.Citizenship FROM resi_new.tbl_staff LIMIT i,1 INTO var_citizenship_name;
		SELECT id FROM citizenship WHERE name = var_citizenship_name LIMIT 1 INTO var_new_citizenship_id;
		
		# get new team id
		SET var_new_team_id = NULL;
		SET var_team_name = NULL;
		
		SELECT resi_new.tbl_team.Name 
		FROM resi_new.tbl_team 
		LEFT JOIN resi_new.tbl_teamsquatstaffassigned ON resi_new.tbl_teamsquatstaffassigned.TeamID = resi_new.tbl_team.TeamID 
		WHERE resi_new.tbl_teamsquatstaffassigned.RPN = var_rpn INTO var_team_name;
		
		SELECT id FROM team WHERE name = var_team_name LIMIT 1 INTO var_new_team_id;
		
			
		SELECT Rpn,Forname,Surname,Nickname,Gender,Birthdate,Profession,Callsign,Height,Status_IT,Status_Alive,Status_BE13,Status_InBase FROM resi_new.tbl_staff LIMIT i,1 INTO var_rpn,var_forname,var_surname,var_nickname,var_gender,var_birthdate,var_profession,var_callsign,var_height,var_status_it,var_status_alive,var_status_be13,var_status_in_base;	
		INSERT INTO staff 
			(rpn,forename,surname,nickname,gender,date_of_birth,profession,callsign,height,status_it,status_alive,status_be13,status_in_base,rank_id,base_category_id,special_function_id,company_id,citizenship_id,eye_color_id,team_id,blood_type_id) 
		VALUES
			(var_rpn,var_forname,var_surname,var_nickname,var_gender,var_birthdate,var_profession,var_callsign,var_height,var_status_it,var_status_alive,var_status_be13,var_status_in_base,var_new_rank_id,var_new_base_category_id,var_new_special_function_id,var_new_company_id,var_new_citizenship_id,var_new_eyecolor_id,var_new_team_id,var_new_blood_type_id);
		
		SET i=i+1;
	END WHILE;
END;
;;

DELIMITER ;
CALL staff2staff;
DROP PROCEDURE IF EXISTS staff2staff;
");
    }

    public function actionStartFromResiNew()
    {
        echo "Creating access entries\n";
        $this->execute("
-- --------------------------------------------------------
-- Host:                         localhost
-- Server Version:               10.1.13-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Daten aus Tabelle cic_new.access_category: ~19 rows (ungefähr)
/*!40000 ALTER TABLE `access_category` DISABLE KEYS */;
INSERT IGNORE INTO `access_category` (`id`, `name`, `order`) VALUES
	(1, 'Staff', 1),
	(2, 'Staff File Memos', 2),
	(3, 'Teams', 8),
	(4, 'Staff Background', 3),
	(5, 'Security Level', 4),
	(6, 'Missions', 5),
	(7, 'Access Categories', 11),
	(8, 'Operations', 6),
	(9, 'Access Masks', 9),
	(10, 'Access Rights', 12),
	(11, 'Security Areas', 10),
	(12, 'Base Categories', 13),
	(13, 'Citizenships', 14),
	(14, 'Companies', 15),
	(15, 'Eye Colors', 16),
	(16, 'Ranks', 17),
	(17, 'Special Functions', 18),
	(18, 'Users', 7),
	(19, 'Medicine Checkup', 19),
	(20, 'Medicine Treatment', 20),
	(21, 'Medicine Drug', 21),
	(22, 'Site', 22);
/*!40000 ALTER TABLE `access_category` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle cic_new.access_right: ~99 rows (ungefähr)
/*!40000 ALTER TABLE `access_right` DISABLE KEYS */;
INSERT IGNORE INTO `access_right` (`id`, `key`, `name`, `comment`, `order`, `access_category_id`) VALUES
	(1, 'staff/view', 'View Staff', '', 1, 1),
	(2, 'staff/create', 'Create Staff', '', 2, 1),
	(3, 'staff/update', 'Update Staff', '', 3, 1),
	(4, 'staff/delete', 'Delete Staff', '', 4, 1),
	(5, 'staff/grant-rights', 'Grant Rights to Staff', '', 5, 1),
	(6, 'staff/block', 'Block Staff from Missions', '', 6, 1),
	(7, 'staff-file-memo/view', 'View Staff File Memos', '', 7, 2),
	(8, 'staff-file-memo/create', 'Create Staff File Memos', '', 8, 2),
	(9, 'staff-file-memo/update', 'Update Staff File Memos', '', 9, 2),
	(10, 'staff-file-memo/delete', 'Delete Staff File Memos', '', 10, 2),
	(11, 'team/view', 'View Teams', '', 11, 3),
	(12, 'team/create', 'Create Teams', '', 12, 3),
	(13, 'team/update', 'Update Teams', '', 13, 3),
	(14, 'team/delete', 'Delete Teams', '', 14, 3),
	(15, 'staff-background/view', 'View Staff Background', NULL, 15, 4),
	(16, 'staff-background/create', 'Create Staff Background', NULL, 16, 4),
	(17, 'staff-background/update', 'Update Staff Background', NULL, 17, 4),
	(18, 'staff-background/delete', 'Delete Staff Background', NULL, 18, 4),
	(20, 'security-level/1', 'Security Level 1', NULL, 19, 5),
	(21, 'security-level/2', 'Security Level 2', NULL, 20, 5),
	(22, 'security-level/3', 'Security Level 3', NULL, 21, 5),
	(23, 'security-level/4', 'Security Level 4', NULL, 22, 5),
	(24, 'security-level/5', 'Security Level 5', NULL, 23, 5),
	(27, 'security-level/6', 'Security Level 6', NULL, 24, 5),
	(28, 'security-level/7', 'Security Level 7', NULL, 25, 5),
	(29, 'security-level/8', 'Security Level 8', NULL, 26, 5),
	(31, 'security-level/9', 'Security Level 9', NULL, 27, 5),
	(32, 'mission/view', 'View Mission', NULL, 28, 6),
	(33, 'mission/create', 'Create Mission', NULL, 29, 6),
	(34, 'mission/update', 'Update Mission', NULL, 30, 6),
	(35, 'mission/delete', 'Delete Mission', NULL, 31, 6),
	(36, 'mission/templates', 'View Mission Templates', NULL, 32, 6),
	(37, 'mission/archive', 'View Mission Archive', NULL, 33, 6),
	(38, 'mission/control', 'Access Mission Control', NULL, 34, 6),
	(39, 'mission/planned', 'View Planned Missions', NULL, 35, 6),
	(40, 'mission/called', 'View Called Mission ', NULL, 36, 6),
	(41, 'mission/active', 'View Active Missions', NULL, 37, 6),
	(42, 'mission/debrief', 'Debrief Missions', NULL, 38, 6),
	(43, 'access-category/view', 'View Access Category', NULL, 39, 7),
	(44, 'access-category/create', 'Create Access Category', NULL, 40, 7),
	(45, 'access-category/update', 'Update Access Category', NULL, 41, 7),
	(46, 'access-category/delete', 'Delete Access Category', NULL, 42, 7),
	(47, 'operation/view', 'View Operation', NULL, 43, 8),
	(48, 'operation/create', 'Create Operation', NULL, 44, 8),
	(49, 'operation/update', 'Update Operation', NULL, 45, 8),
	(50, 'operation/delete', 'Delete Operation', NULL, 46, 8),
	(51, 'access-mask/view', 'View Access Mask', NULL, 47, 9),
	(52, 'access-mask/create', 'Create Access Mask', NULL, 48, 9),
	(53, 'access-mask/update', 'Update Access Mask', NULL, 49, 9),
	(54, 'access-mask/delete', 'Delete Access Mask', NULL, 50, 9),
	(55, 'access-right/view', 'View Access Right', NULL, 51, 10),
	(56, 'access-right/create', 'Create Access Right', NULL, 52, 10),
	(57, 'access-right/update', 'Update Access Right', NULL, 53, 10),
	(58, 'access-right/delete', 'Delete Access Right', NULL, 54, 10),
	(59, 'access-security-area/view', 'View Access Security Area', NULL, 55, 11),
	(60, 'access-security-area/create', 'Create Access Security Area', NULL, 56, 11),
	(61, 'access-security-area/update', 'Update Access Security Area', NULL, 57, 11),
	(62, 'access-security-area/delete', 'Delete Access Security Area', NULL, 58, 11),
	(63, 'base-category/view', 'View Base Category', NULL, 59, 12),
	(64, 'base-category/create', 'Create Base Category', NULL, 60, 12),
	(65, 'base-category/update', 'Update Base Category', NULL, 61, 12),
	(66, 'base-category/delete', 'Delete Base Category', NULL, 62, 12),
	(67, 'citizenship/view', 'View Citizenship', NULL, 63, 13),
	(68, 'citizenship/create', 'Create Citizenship', NULL, 64, 13),
	(69, 'citizenship/update', 'Update Citizenship', NULL, 65, 13),
	(70, 'citizenship/delete', 'Delete Citizenship', NULL, 66, 13),
	(71, 'company/view', 'View Company', NULL, 67, 14),
	(72, 'company/create', 'Create Company', NULL, 68, 14),
	(73, 'company/update', 'Update Company', NULL, 69, 14),
	(74, 'company/delete', 'Delete Company', NULL, 70, 14),
	(75, 'eye-color/view', 'View Eye Color', NULL, 71, 15),
	(76, 'eye-color/create', 'Create Eye Color', NULL, 72, 15),
	(77, 'eye-color/update', 'Update Eye Color', NULL, 73, 15),
	(78, 'eye-color/delete', 'Delete Eye Color', NULL, 74, 15),
	(79, 'rank/view', 'View Rank', NULL, 75, 16),
	(80, 'rank/create', 'Create Rank', NULL, 76, 16),
	(81, 'rank/update', 'Update Rank', NULL, 77, 16),
	(82, 'rank/delete', 'Delete Rank', NULL, 78, 16),
	(83, 'special-function/view', 'View Special Function', NULL, 79, 17),
	(84, 'special-function/create', 'Create Special Function', NULL, 80, 17),
	(85, 'special-function/update', 'Update Special Function', NULL, 81, 17),
	(86, 'special-function/delete', 'Delete Special Function', NULL, 82, 17),
	(87, 'user/view', 'View User', NULL, 83, 18),
	(88, 'user/create', 'Create User', NULL, 84, 18),
	(89, 'user/update', 'Update User', NULL, 85, 18),
	(90, 'user/delete', 'Delete User', NULL, 86, 18),
	(92, 'user/approve', 'Approve Users', NULL, 87, 18),
	(93, 'medicine-checkup/view', 'View Medicine Checkup', NULL, 88, 19),
	(94, 'medicine-checkup/create', 'Create Medicine Checkup', NULL, 89, 19),
	(95, 'medicine-checkup/update', 'Update Medicine Checkup', NULL, 90, 19),
	(96, 'medicine-checkup/delete', 'Delete Medicine Checkup', NULL, 91, 19),
	(97, 'medicine-treatment/view', 'View Medicine Treatment', NULL, 92, 20),
	(98, 'medicine-treatment/create', 'Create Medicine Treatment', NULL, 93, 20),
	(99, 'medicine-treatment/update', 'Update Medicine Treatment', NULL, 94, 20),
	(100, 'medicine-treatment/delete', 'Delete Medicine Treatment', NULL, 95, 20),
	(101, 'medicine-drug/view', 'View Medicine Drug', NULL, 96, 21),
	(102, 'medicine-drug/create', 'Create Medicine Drug', NULL, 97, 21),
	(103, 'medicine-drug/update', 'Update Medicine Drug', NULL, 98, 21),
	(104, 'medicine-drug/delete', 'Delete Medicine Drug', NULL, 99, 21),
	(105, 'site/clear-cache', 'Clear Cache', '', 100, 22);
/*!40000 ALTER TABLE `access_right` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle cic_new.access_mask: ~23 rows (ungefähr)
/*!40000 ALTER TABLE `access_mask` DISABLE KEYS */;
INSERT IGNORE INTO `access_mask` (`id`, `name`, `protected`) VALUES
	(1, 'Basis Kategorie Stab', 1),
	(2, 'Basis Kategorie Forschung', 1),
	(3, 'Basis Kategorie Medizin', 1),
	(4, 'Basis Kategorie Technik', 1),
	(5, 'Basis Kategorie Sicherheit', 1),
	(6, 'Basis Kategorie Council of Humanity', 1),
	(7, 'Basis Kategorie T.A.O.', 1),
	(8, 'Basis Kategorie TacRec', 1),
	(9, 'Basis Kategorie GDA', 1),
	(10, 'Basis Kategorie Fighter', 1),
	(11, 'Rank Civilian', 1),
	(12, 'Rank Volunteer', 1),
	(13, 'Rank Recruit', 1),
	(14, 'Rank Fighter', 1),
	(15, 'Rank Specialist', 1),
	(16, 'Rank Corporal', 1),
	(17, 'Rank Corporal Specialist', 1),
	(18, 'Rank Sergeant', 1),
	(19, 'Rank Sergeant Specialist', 1),
	(20, 'Rank Master Sergeant', 1),
	(21, 'Rank Lieutenant', 1),
	(22, 'Rank First Lieutenant', 1),
	(23, 'Rank Commander', 1);
/*!40000 ALTER TABLE `access_mask` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle cic_new.access_mask_right: ~48 rows (ungefähr)
/*!40000 ALTER TABLE `access_mask_right` DISABLE KEYS */;
INSERT IGNORE INTO `access_mask_right` (`access_mask_id`, `access_right_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 11),
	(1, 12),
	(1, 13),
	(1, 7),
	(1, 8),
	(1, 9),
	(1, 15),
	(1, 16),
	(1, 17),
	(1, 20),
	(1, 21),
	(1, 22),
	(1, 23),
	(1, 32),
	(1, 33),
	(1, 34),
	(1, 35),
	(1, 37),
	(1, 38),
	(1, 42),
	(1, 36),
	(23, 20),
	(23, 21),
	(23, 22),
	(23, 23),
	(23, 24),
	(23, 27),
	(23, 28),
	(23, 29),
	(23, 31),
	(2, 1),
	(2, 7),
	(2, 20),
	(2, 21),
	(2, 22),
	(2, 23),
	(2, 24),
	(2, 32),
	(2, 37),
	(2, 47),
	(2, 11),
	(2, 59),
	(2, 60),
	(2, 61),
	(3, 93),
	(3, 94),
	(3, 95),
	(3, 97),
	(3, 98),
	(3, 99),
	(1, 6);
/*!40000 ALTER TABLE `access_mask_right` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle cic_new.access_security_area: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `access_security_area` DISABLE KEYS */;
/*!40000 ALTER TABLE `access_security_area` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle cic_new.base_category: ~10 rows (ungefähr)
/*!40000 ALTER TABLE `base_category` DISABLE KEYS */;
INSERT IGNORE INTO `base_category` (`id`, `name`, `access_mask_id`, `order`) VALUES
	(1, 'Kämpfer', 10, 1),
	(2, 'Basis Forschung', 2, 6),
	(3, 'Basis Medizin', 3, 3),
	(4, 'Basis Sicherheit', 5, 5),
	(5, 'Basis Technik', 4, 4),
	(6, 'Stab', 1, 2),
	(7, 'Council of Humanity', 6, 7),
	(8, 'T.A.O.', 7, 8),
	(9, 'GDA', 9, 10),
	(10, 'TacRec', 8, 9);
	(11, 'Sonstiges', null, 11);
/*!40000 ALTER TABLE `base_category` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle cic_new.rank: ~28 rows (ungefähr)
/*!40000 ALTER TABLE `rank` DISABLE KEYS */;
INSERT IGNORE INTO `rank` (`id`, `name`, `short_name`, `access_mask_id`, `order`) VALUES
	(2, 'Civilian', 'C', 11, 1),
	(3, 'Volunteer', 'V', 12, 2),
	(4, 'Recruit', 'R', 13, 3),
	(5, 'Resistance Fighter Mark 1', 'RF-MK-I', 14, 4),
	(6, 'Resistance Fighter Mark 2', 'RF-MK-II', 14, 5),
	(7, 'Resistance Fighter Mark 3', 'RF-MK-III', 14, 6),
	(8, 'Specialist Mark 1', 'SP-MK-I', 15, 7),
	(9, 'Specialist Mark 2', 'SP-MK-II', 15, 8),
	(10, 'Specialist Mark 3', 'SP-MK-III', 15, 9),
	(11, 'Corporal Mark 1', 'CP-MK-I', 16, 10),
	(12, 'Corporal Mark 2', 'CP-MK-II', 16, 11),
	(13, 'Corporal Mark 3', 'CP-MK-III', 16, 12),
	(14, 'Corporal Specialist Mark 1', 'CPSP-MK-I', 17, 13),
	(15, 'Corporal Specialist Mark 2', 'CPSP-MK-II', 17, 14),
	(16, 'Corporal Specialist Mark 3', 'CPSP-MK-III', 17, 15),
	(17, 'Sergeant Mark 1', 'SG-MK-I', 18, 16),
	(18, 'Sergeant Mark 2', 'SG-MK-II', 18, 17),
	(19, 'Sergeant Mark 3', 'SG-MK-III', 18, 18),
	(20, 'Sergeant Specialist  Mark 1', 'SGSP-MK-I', 19, 19),
	(21, 'Sergeant Specialist  Mark 2', 'SGSP-MK-II', 19, 20),
	(22, 'Sergeant Specialist  Mark 3', 'SGSP-MK-III', 19, 21),
	(23, 'Master Sergeant', 'MSG', 20, 22),
	(24, 'Master Sergeant', 'MSGSP', 20, 23),
	(25, 'Lieutenant', 'LT', 21, 24),
	(26, 'Lieutenant', 'LTSP', 21, 25),
	(27, 'First Lieutenant / Executive Officer', 'XO', 22, 26),
	(28, 'First Lieutenant / Executive Officer', 'XOSP', 21, 27),
	(29, 'Commander', 'Co', 23, 28);
/*!40000 ALTER TABLE `rank` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
        echo "Done. Please execute migrations script now and call finish-from-resi-new afterwards.\n";
    }

    public function actionFinishFromResiNew()
    {
        echo "Processing new staff entries\n";
        /** @var Staff[] $staffs */
        $staffs = Staff::find()->all();
        foreach ($staffs as $staff) {
            if ($staff->access_key_id) {
                continue;
            }
            $accessKey = new AccessKey();
            $accessKey->save();
            $staff->access_key_id = $accessKey->id;
            $staff->save();
        }
        /** @var StaffForm[] $staffForms */
        $staffForms = StaffForm::find()->all();
        $errors = 0;
        $success = 0;
        $exceptions = 0;
        foreach ($staffForms as $staffForm) {
            $saved = false;
            try {
                $saved = $staffForm->save();
            } catch (\Exception $e) {
                $exceptions++;
            }
            if (!$saved) {
                $errors++;
            } else {
                $success++;
            }
        }
        echo "Done. $errors Errors ($exceptions Exceptions) and $success successful\n";
    }

    public function actionMigrateTeams()
    {
        $oldTeams = $this->queryAll("
        SELECT resi_new.tbl_staff.Rpn as rpn, resi_new.tbl_team.Name as team FROM resi_new.tbl_staff
            LEFT JOIN resi_new.tbl_teamsquatstaffassigned ON resi_new.tbl_staff.Rpn = resi_new.tbl_teamsquatstaffassigned.RPN
            LEFT JOIN resi_new.tbl_team ON resi_new.tbl_team.TeamID = resi_new.tbl_teamsquatstaffassigned.TeamID;
        ");

        $teamNames = array_flip(array_flip(array_filter(array_column($oldTeams, 'team'))));
        $total = count($teamNames);
        $current = 0;
        $teamIds = [];
        echo "Get Team IDs $current/$total";
        foreach ($teamNames as $teamName) {
            $current++;
            echo "\rGet Team IDs $current/$total";
            if ($teamName == null || $teamName == 'keins') {
                continue;
            }
            $team = Team::findOne(['name' => $teamName]);
            if ($team) {
                $teamIds[$teamName] = $team->id;
            }
        }
        echo "\n";

        $total = count($oldTeams);
        $current = 0;
        echo "Add Staff Team $current/$total";
        foreach ($oldTeams as $oldTeam) {
            $current++;
            echo "\rAdd Staff Team $current/$total";
            $staff = Staff::findOne($oldTeam['rpn']);
            if ($staff->team_id === null && $staff && isset($teamIds[$oldTeam['team']])) {
                $staff->team_id = $teamIds[$oldTeam['team']];
                $staff->save();
            }
        }
        echo "\nDone.";
    }

    public function actionCheckAllAssocs()
    {
        foreach (self::$associationParams as $table => $tableOptionsSet) {
            $this->actionCheckAssoc($table);
        }
    }

    public function actionCheckAssoc($table)
    {
        if (!isset(self::$associationParams[$table])) {
            echo "No association options found for table $table";
            return false;
        }
        $assocOptions = self::$associationParams[$table];
        echo "\nChecking $table\n";
        $this->checkStaffAssoc(
            $assocOptions[0],
            $assocOptions[1],
            $assocOptions[2],
            $assocOptions[3],
            $assocOptions[4],
            $assocOptions[5],
            $assocOptions[6]
        );
        echo "\n";
        return null;
    }

    public function checkStaffAssoc($table, $foreignKey, $primaryKey, $newTable, $newForeignKey, $modelClass, $resiQuery = null)
    {
        if (!$resiQuery) {
            $resiQuery = "SELECT resi_new.tbl_staff.Rpn as rpn, resi_new.$table.Name as name FROM resi_new.tbl_staff \n"
                . "     LEFT JOIN resi_new.$table ON resi_new.tbl_staff.$foreignKey = resi_new.$table.$primaryKey;";
        }
        $oldEntries = $this->queryAll($resiQuery);

        $newEntriesQuery = "SELECT rpn, $newTable.name as name FROM staff \n"
            . "     LEFT JOIN $newTable ON staff.$newForeignKey = $newTable.id;";
        $newEntries = $this->queryAll($newEntriesQuery);

        if($this->verbose) {
            echo "\nExecuted Queries:\n";
            echo $resiQuery.  "\n";
            echo $newEntriesQuery.  "\n\n";
        }

        $newEntries = array_combine(
            array_column($newEntries, "rpn"),
            array_column($newEntries, "name")
        );
        $oldEntries = array_combine(
            array_column($oldEntries, "rpn"),
            array_column($oldEntries, "name")
        );
        foreach ($oldEntries as $rpn => $name) {
            if (in_array($name, ['keins', 'kein', 'keine', 'n/a', 'k.a.', ''])) {
                $oldEntries[$rpn] = null;
            }
        }
        ksort($oldEntries);
        ksort($newEntries);

        $diff = [];
        $changeTo = [];
        $fixed = 0;
        foreach ($oldEntries as $rpn => $name) {
            if (!array_key_exists($rpn, $newEntries)) {
                $diff[$rpn] = "RPN does not exist in new DB";
            }
            if ($newEntries[$rpn] == $name) {
                continue;
            }
            $diff[$rpn] = $newEntries[$rpn] . " should be " . $name;
            $changeTo[$rpn] = $name;

            /** @var ActiveRecord $modelClass */
            /** @var ActiveRecord $newModel */
            $newModel = new $modelClass();
            if(!$newModel->hasAttribute('name')) {
                continue;
            }
            $addModel = $modelClass::findOne(['name' => $name]);
            if(!$addModel) {
                $addModel = $newModel;
                $addModel->name = $name;
                if(!$addModel->save()) {
                    continue;
                }
            }
            $staff = Staff::findOne($rpn);
            if ($staff) {
                $staff->$newForeignKey = $addModel->id;
                if ($staff->save()) {
                    $fixed++;
                }
            }
        }

        echo "Checking for upper/lower-case only differences\n";
        /** @var ActiveRecord[] $checkModels */
        $checkModels = $modelClass::find()->all();
        /** @var ActiveRecord[] $compareModels */
        $compareModels = $modelClass::find()->all();
        $compareValues = array_combine(
            ArrayHelper::getColumn($compareModels, 'id'),
            ArrayHelper::getColumn($compareModels, 'name')
        );
        $processEntries = [];
        foreach ($checkModels as $checkModel) {
            $found = [];
            foreach ($compareValues as $id => $name) {
                if(strtolower($name) == strtolower($checkModel->name)) {
                    $found[] = $id;
                }
            }
            if(count($found) > 1) {
                $processEntries[] = $found;
            }
        }
        $processed = [];
        $normalized = 0;
        foreach ($processEntries as $process) {
            if(!empty(array_intersect($processed, $process))) {
                continue;
            }
            $processed += $process;
            $normalized += count($process);
            $useId = $process[0];
            unset($process[0]);
            $replaceIds = $process;
            Staff::updateAll(
                [$newForeignKey => $useId],
                [$newForeignKey => $replaceIds]
            );
            $modelClass::deleteAll(['id' => $process]);
        }
        echo "$normalized entries of $newTable have been normalized\n";


        echo "Count: " . count($newEntries) . " new and " . count($oldEntries) . " old\n";
        $diffCount = count($diff);
        echo "$diffCount different";
        if (!empty($diff)) {
            echo "\nDIFFERENCES FOUND!";
            if ($diffCount > 15) {
                echo "(First 15 are shown)\n";
                $diff = array_slice($diff, 0, 15);
            }
            foreach ($diff as $rpn => $message) {
                echo "\n$rpn: $message";
            }
            echo "\n$fixed of $diffCount differences were fixed";
        }
    }

    protected function queryAll($sql, $params = [])
    {
        return Yii::$app->db->createCommand($sql)->bindValues($params)->queryAll(\PDO::FETCH_ASSOC);
    }

    protected function execute($sql, $params = [])
    {
        return Yii::$app->db->createCommand($sql)->bindValues($params)->execute();
    }
}
