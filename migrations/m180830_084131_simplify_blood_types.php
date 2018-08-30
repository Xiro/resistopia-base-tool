<?php

use yii\db\Migration;

/**
 * Class m180830_084131_simplify_blood_types
 */
class m180830_084131_simplify_blood_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $bloodTypeMerges = [
            [
                'keep'   => '0 Rh neg. Kell pos.',
                'remove' => '0 Rh neg. Kell neg.',
                'new'    => '0 Rh neg.',
            ],
            [
                'keep'   => '0 Rh pos. Kell pos.',
                'remove' => '0 Rh pos. Kell neg.',
                'new'    => '0 Rh pos.',
            ],
            [
                'keep'   => 'A Rh neg. Kell pos.',
                'remove' => 'A Rh neg. Kell neg.',
                'new'    => 'A Rh neg.',
            ],
            [
                'keep'   => 'A Rh pos. Kell pos.',
                'remove' => 'A Rh pos. Kell neg.',
                'new'    => 'A Rh pos.',
            ],
            [
                'keep'   => 'B Rh neg. Kell pos.',
                'remove' => 'B Rh neg. Kell neg.',
                'new'    => 'B Rh neg.',
            ],
            [
                'keep'   => 'B Rh pos. Kell pos.',
                'remove' => 'B Rh pos. Kell neg.',
                'new'    => 'B Rh pos.',
            ],
            [
                'keep'   => 'AB Rh neg. Kell pos.',
                'remove' => 'AB Rh neg. Kell neg.',
                'new'    => 'AB Rh neg.',
            ],
            [
                'keep'   => 'AB Rh pos. Kell pos.',
                'remove' => 'AB Rh pos. Kell neg.',
                'new'    => 'AB Rh pos.',
            ],
        ];
        foreach ($bloodTypeMerges as $bloodTypeMerge) {
            $this->execute(
                "UPDATE staff SET blood_type_id = (SELECT id FROM blood_type WHERE name = :keep) 
                        WHERE blood_type_id = (SELECT id FROM blood_type WHERE name = :remove);
                    DELETE FROM blood_type WHERE name = :remove;
                    UPDATE blood_type SET name = :new WHERE name = :keep;",
                $bloodTypeMerge
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180830_084131_simplify_blood_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_084131_simplify_blood_types cannot be reverted.\n";

        return false;
    }
    */
}
