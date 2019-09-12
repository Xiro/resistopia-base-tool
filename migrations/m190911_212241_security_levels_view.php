<?php

use yii\db\Migration;

/**
 * Class m190911_212241_security_levels_view
 */
class m190911_212241_security_levels_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE ALGORITHM = UNDEFINED VIEW `staff_security_levels` AS SELECT sid, SUBSTRING(amr_ar.key, 16) as security_level FROM staff s
            JOIN access_key_mask as akm ON s.access_key_id = akm.access_key_id
            JOIN access_mask_right as amr ON akm.access_mask_id = amr.access_mask_id
            JOIN access_right as amr_ar ON amr.access_right_id = amr_ar.id
            WHERE amr_ar.key LIKE 'security-level/%'
        UNION
        SELECT sid, SUBSTRING(akr_ar.key, 16) as security_level FROM staff s
            JOIN access_key_right as akr ON s.access_key_id = akr.access_key_id
            JOIN access_right as akr_ar ON akr.access_right_id = akr_ar.id
            WHERE akr_ar.key LIKE 'security-level/%'
            ORDER BY security_level DESC ;
            
        CREATE ALGORITHM = UNDEFINED VIEW `staff_security_level` AS SELECT sid, MAX(security_level) as security_level FROM staff_security_levels GROUP BY sid ;

        ALTER TABLE `staff_column_display`
            ADD COLUMN `security_level` TINYINT(1) NOT NULL DEFAULT '0' AFTER `rank`;

        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190911_212241_security_levels_view cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190911_212241_security_levels_view cannot be reverted.\n";

        return false;
    }
    */
}
