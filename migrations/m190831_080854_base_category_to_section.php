<?php

use yii\db\Migration;

/**
 * Class m190831_080854_base_category_to_section
 */
class m190831_080854_base_category_to_section extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `staff`
            CHANGE COLUMN `base_category_id` `section_id` INT(11) NULL DEFAULT NULL AFTER `rank_id`;
        RENAME TABLE `base_category` TO `section`;

        ");

        $sections = \app\models\Section::find()->all();
        /** @var \app\models\Section $section */
        foreach ($sections as $section) {
            $accessMask = $section->accessMask;
            $section->delete();
            if($accessMask) {
                $accessMask->delete();
            }
        }

        $this->execute("
        ALTER TABLE `section`
        ALTER `name` DROP DEFAULT;
        ALTER TABLE `section`
            CHANGE COLUMN `name` `section` VARCHAR(255) NOT NULL COLLATE 'utf8_bin' AFTER `id`,
            ADD COLUMN `department` VARCHAR(255) NOT NULL AFTER `section`,
            ADD COLUMN `group` VARCHAR(255) NOT NULL AFTER `department`;
        ");

        $sectionDataSets = [
            [
                "group"      => "Combat",
                "section"    => "Combat",
                "department" => "Combat",
            ],
            [
                "group"      => "Coordination",
                "section"    => "CIC",
                "department" => "Command Support",
            ],
            [
                "group"      => "Coordination",
                "section"    => "CIC",
                "department" => "Missions & Operations",
            ],
            [
                "group"      => "Coordination",
                "section"    => "CIC",
                "department" => "Information & Communication",
            ],
            [
                "group"      => "Coordination",
                "section"    => "CIC",
                "department" => "Intelligence & Research",
            ],
            [
                "group"      => "Coordination",
                "section"    => "CIC",
                "department" => "Security",
            ],
            [
                "group"      => "Coordination",
                "section"    => "CIC",
                "department" => "Resistance Consultant",
            ],
            [
                "group"      => "Coordination",
                "section"    => "CIC",
                "department" => "TRF",
            ],
            [
                "group"      => "Coordination",
                "section"    => "Administration",
                "department" => "Personal & Training",
            ],
            [
                "group"      => "Coordination",
                "section"    => "Administration",
                "department" => "News & Post",
            ],
            [
                "group"      => "Coordination",
                "section"    => "Administration",
                "department" => "Court Office",
            ],
            [
                "group"      => "Support",
                "section"    => "Medical",
                "department" => "Doctors",
            ],
            [
                "group"      => "Support",
                "section"    => "Medical",
                "department" => "Nurses",
            ],
            [
                "group"      => "Support",
                "section"    => "Medical",
                "department" => "Field Medics",
            ],
            [
                "group"      => "Support",
                "section"    => "Technical",
                "department" => "Tech Surveillance",
            ],
            [
                "group"      => "Support",
                "section"    => "Technical",
                "department" => "Tech Research",
            ],
            [
                "group"      => "Support",
                "section"    => "Logistic",
                "department" => "Magazin",
            ],
            [
                "group"      => "Support",
                "section"    => "Logistic",
                "department" => "Schalter",
            ],
            [
                "group"      => "Support",
                "section"    => "Logistic",
                "department" => "Bar",
            ],
        ];
        foreach ($sectionDataSets as $i => $sectionData) {
            $addSection = new \app\models\Section();
            $addSection->load(["Section" => $sectionData]);
            $addSection->order = $i + 1;

            $sectionMask = new \app\models\AccessMask();
            $sectionMask->name = "Section " . $addSection->section . " - " . $addSection->department;
            $sectionMask->protected = 1;
            $sectionMask->save();
            $addSection->access_mask_id = $sectionMask->id;
            $addSection->save();
        }

        $rights = \app\models\AccessRight::find()->where(['LIKE', 'key', 'base-category'])->all();
        foreach ($rights as $right) {
            $right->delete();
        }
        \app\models\AccessCategory::findOne(['name' => 'Base Categories'])->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190831_080854_base_category_to_section cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190831_080854_base_category_to_section cannot be reverted.\n";

        return false;
    }
    */
}
