<?php

use yii\db\Migration;

/**
 * Class m180901_092947_rest_api
 */
class m180901_092947_rest_api extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `user`
            ADD COLUMN `access_token` VARCHAR(32) NULL AFTER `auth_key`,
            ADD UNIQUE INDEX `access_token` (`access_token`);
        ALTER TABLE `user`
	        ADD COLUMN `token_expire` DATETIME NULL DEFAULT NULL AFTER `access_token`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180901_092947_rest_api cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180901_092947_rest_api cannot be reverted.\n";

        return false;
    }
    */
}
