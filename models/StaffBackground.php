<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_background".
 *
 * @property integer $id
 * @property string $rpn
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
 * @property Staff $rpn0
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
            [['rpn'], 'required'],
            [['story_before', 'story_during', 'story_after', 'career', 'characteristics', 'personality', 'awards'], 'string'],
            [['created', 'updated'], 'safe'],
            [['rpn'], 'string', 'max' => 8],
            [['rpn'], 'unique'],
            [['rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['rpn' => 'rpn']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rpn' => 'Rpn',
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
    public function getRpn0()
    {
        return $this->hasOne(Staff::className(), ['rpn' => 'rpn']);
    }
}
