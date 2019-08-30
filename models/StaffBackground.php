<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_background".
 *
 * @property integer $id
 * @property string $sid
 * @property string $story_before
 * @property string $story_during
 * @property string $story_after
 * @property string $career
 * @property string $characteristics
 * @property string $personality
 * @property string $awards
 * @property string $created
 * @property string $updated
 *
 * @property Staff $staff
 */
class StaffBackground extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_background';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid'], 'required'],
            [['story_before', 'story_during', 'story_after', 'career', 'characteristics', 'personality', 'awards'], 'string'],
            [['created', 'updated'], 'safe'],
            [['sid'], 'string', 'max' => 8],
            [['sid'], 'unique'],
            [['sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['sid' => 'sid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => 'SID',
            'story_before' => 'Story before the invasion',
            'story_during' => 'Story during the invasion',
            'story_after' => 'Story after the invasion',
            'career' => 'Career',
            'characteristics' => 'Characteristics',
            'personality' => 'Personality',
            'awards' => 'Awards',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['sid' => 'sid']);
    }
}
