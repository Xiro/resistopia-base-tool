<?php

use yii\db\Migration;
use app\models\AccessCategory;
use app\models\AccessRight;

/**
 * Class m180911_122142_add_access_rights
 */
class m180911_122142_add_ticker_access_rights extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tickerCategory = new AccessCategory();
        $tickerCategory->name = "Ticker";
        $tickerCategory->order = AccessCategory::find()->count() + 1;
        $tickerCategory->save();

        $rights = [
            [
                'key'                => 'ticker/view',
                'name'               => 'View Ticker Messages',
                'access_category_id' => $tickerCategory->id
            ],
            [
                'key'                => 'ticker/create',
                'name'               => 'Create Ticker Messages',
                'access_category_id' => $tickerCategory->id
            ],
            [
                'key'                => 'ticker/update',
                'name'               => 'Update Ticker Messages',
                'access_category_id' => $tickerCategory->id
            ],
            [
                'key'                => 'ticker/delete',
                'name'               => 'Delete Ticker Messages',
                'access_category_id' => $tickerCategory->id
            ],
        ];
        foreach ($rights as $rightData) {
            $model = new AccessRight();
            $model->setAttributes($rightData);
            $model->order = AccessRight::find()->count() + 1;
            $model->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180911_122142_add_access_rights cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180911_122142_add_access_rights cannot be reverted.\n";

        return false;
    }
    */
}
