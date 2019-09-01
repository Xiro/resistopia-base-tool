<?php

use yii\db\Migration;

/**
 * Class m190830_174657_add_resistance_cell
 */
class m190830_174657_add_resistance_cell extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TABLE `resistance_cell` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL COLLATE 'utf8_bin',
            `latitude` FLOAT NOT NULL,
            `longitude` FLOAT NOT NULL,
            `order` INT(11) NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8_bin'
        ENGINE=InnoDB
        ;

        INSERT INTO `resistance_cell` (`name`, `latitude`, `longitude`, `order`) VALUES ('Widerstandszelle Mahlwinkel', '52.38', '11.82', '1');
        INSERT INTO `resistance_cell` (`name`, `latitude`, `longitude`, `order`) VALUES ('Colbitzer Lindenwald', '52.34', '11.54', '2');
        INSERT INTO `resistance_cell` (`name`, `latitude`, `longitude`, `order`) VALUES ('Widerstandszelle Alex', '52.25', '13.41', '3');
        INSERT INTO `resistance_cell` (`name`, `latitude`, `longitude`, `order`) VALUES ('Widerstandszelle Friedrichshain', '52.52', '13.43', '4');
        INSERT INTO `resistance_cell` (`name`, `latitude`, `longitude`, `order`) VALUES ('Widerstandszelle Spandau', '52.54', '13.21', '5');
        
        
        INSERT INTO `access_category` (`name`, `order`) VALUES ('Resistance Cell', '26');
        
        ");
        $accessCategory = \app\models\AccessCategory::findOne(['name' => 'Resistance Cell']);
        $catId = $accessCategory->id;
        $this->execute("
        INSERT INTO `access_right` (`key`, `name`, `order`, `access_category_id`) VALUES ('resistance-cell/view', 'View Resistance Cells', '114', '$catId');
        INSERT INTO `access_right` (`key`, `name`, `order`, `access_category_id`) VALUES ('resistance-cell/create', 'Create Resistance Cells', '115', '$catId');
        INSERT INTO `access_right` (`key`, `name`, `order`, `access_category_id`) VALUES ('resistance-cell/update', 'Update Resistance Cells', '116', '$catId');
        INSERT INTO `access_right` (`key`, `name`, `order`, `access_category_id`) VALUES ('resistance-cell/delete', 'Delete Resistance Cells', '117', '$catId');
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190830_174657_add_resistance_cell cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190830_174657_add_resistance_cell cannot be reverted.\n";

        return false;
    }
    */
}
