<?php

use yii\db\Migration;

/**
 * Class m180906_140122_add_file_memo_number
 */
class m180906_140122_add_file_memo_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `staff_file_memo`
            ADD COLUMN `file_memo_number` VARCHAR(16) NULL AFTER `id`;
        ALTER TABLE `staff_file_memo`
            CHANGE COLUMN `file_memo_number` `file_memo_number` VARCHAR(14) NULL DEFAULT NULL COLLATE 'utf8_bin' AFTER `id`,
        	ADD UNIQUE INDEX `file_memo_number` (`file_memo_number`);
        ");
        /** @var \app\models\StaffFileMemo[] $staffFileMemos */
        $staffFileMemos = \app\models\StaffFileMemo::find()->all();
        foreach ($staffFileMemos as $staffFileMemo) {
            $staffFileMemo->file_memo_number = $staffFileMemo->rpn . '-' . str_pad($staffFileMemo->id, 4, '0', STR_PAD_LEFT);
            $staffFileMemo->save();
        }
        $this->execute("
        ALTER TABLE `staff_file_memo`
            CHANGE COLUMN `file_memo_number` `file_memo_number` VARCHAR(14) NOT NULL COLLATE 'utf8_bin' AFTER `id`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180906_140122_add_file_memo_number cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_140122_add_file_memo_number cannot be reverted.\n";

        return false;
    }
    */
}
