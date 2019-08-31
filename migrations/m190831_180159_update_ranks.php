<?php

use yii\db\Migration;

/**
 * Class m190831_180159_update_ranks
 */
class m190831_180159_update_ranks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        ALTER TABLE `staff`
        ALTER `rank_id` DROP DEFAULT;
        ALTER TABLE `staff`
            CHANGE COLUMN `rank_id` `rank_id` INT(11) NULL AFTER `access_key_id`;

        UPDATE staff SET staff.rank_id = NULL;
        ");

        $ranks = \app\models\Rank::find()->all();
        $accessMasks = [];
        /** @var \app\models\Rank $rank */
        foreach ($ranks as $rank) {
            if($rank->access_mask_id) {
                $accessMasks[] = $rank->accessMask;
            }
            $rank->delete();
        }
        /** @var \app\models\AccessMask $accessMask */
        foreach ($accessMasks as $accessMask) {
            $accessMask->delete();
        }

        $rankDataSets = [
            [
                "name"       => "Private",
                "short_name" => "PVT",
            ],
            [
                "name"       => "Private First Class",
                "short_name" => "PFC",
            ],
            [
                "name"       => "Lance Corporal",
                "short_name" => "LCPL",
            ],
            [
                "name"       => "Corporal",
                "short_name" => "CPL",
            ],
            [
                "name"       => "Sergeant",
                "short_name" => "SGT",
            ],
            [
                "name"       => "Master Sergeant",
                "short_name" => "MSGT",
            ],
            [
                "name"       => "Warrant Officer",
                "short_name" => "WO",
            ],
            [
                "name"       => "Lieutenant",
                "short_name" => "LT",
            ],
            [
                "name"       => "Lieutenant Commander",
                "short_name" => "LCDR",
            ],
            [
                "name"       => "Commander",
                "short_name" => "CDR",
            ],
        ];
        foreach ($rankDataSets as $i => $rankData) {
            $addRank = new \app\models\Rank();
            $addRank->load(["Rank" => $rankData]);
            $addRank->order = $i + 1;

            $rankMask = new \app\models\AccessMask();
            $rankMask->name = "Rank " . $addRank->name;
            $rankMask->protected = 1;
            $rankMask->save();

            $addRank->access_mask_id = $rankMask->id;
            $addRank->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190831_180159_update_ranks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190831_180159_update_ranks cannot be reverted.\n";

        return false;
    }
    */
}
