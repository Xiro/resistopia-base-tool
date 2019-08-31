<?php

use yii\db\Migration;
use app\models\Section;
use yii\helpers\Inflector;

/**
 * Class m180906_152057_add_base_category_keys
 */
class m180906_152057_add_base_category_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->execute("
        UPDATE base_category SET name = 'Fighter' WHERE name = 'Kämpfer';
        ");
        $this->execute("
        ALTER TABLE `base_category`
            ADD COLUMN `key` VARCHAR(50) NOT NULL AFTER `name`;
        ");

        /** @var Section[] $baseCategories */
        $baseCategories = Section::find()->all();
        foreach ($baseCategories as $baseCategory) {
            $baseCategory->key = Inflector::camel2id(Inflector::camelize($baseCategory->name));
            $baseCategory->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180906_152057_add_base_category_keys cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_152057_add_base_category_keys cannot be reverted.\n";

        return false;
    }
    */
}
