<?php

use yii\db\Migration;

class m170913_161611_missions extends Migration
{
    public function safeUp()
    {
        $this->execute("CREATE TABLE `mission_staff` (
            `mission_id` INT NOT NULL,
            `staff_id` INT NOT NULL,
            `paid` ENUM('Yes','No') NOT NULL DEFAULT 'No',
            UNIQUE INDEX `mission_id` (`mission_id`, `staff_id`),
            CONSTRAINT `FK__mission` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`),
            CONSTRAINT `FK__staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;
        ");
        $this->execute("ALTER TABLE `mission`
            ADD COLUMN `operation_id` INT(11) NOT NULL AFTER `debrief_comment`,
            ADD CONSTRAINT `FK_mission_operation` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`);
        ");
        $this->execute("ALTER TABLE `operation`
            DROP INDEX `name`,
            ADD UNIQUE INDEX `name` (`name`);
        ");
    }

    public function safeDown()
    {
        echo "m170913_161611_missions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170913_161611_missions cannot be reverted.\n";

        return false;
    }
    */
}
