<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_file_memo".
 *
 * @property integer $id
 * @property string $title
 * @property string $file_memo
 * @property integer $access_bit_id
 * @property string $rpn
 * @property string $author_rpn
 * @property string $created
 * @property string $updated
 *
 * @property AccessBit $accessBit
 * @property Staff $staff
 * @property Staff $author
 */
class StaffFileMemo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_file_memo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'file_memo', 'rpn', 'author_rpn'], 'required'],
            [['file_memo'], 'string'],
            [['access_bit_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['rpn', 'author_rpn'], 'string', 'max' => 8],
            [['access_bit_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessBit::className(), 'targetAttribute' => ['access_bit_id' => 'bit_pos']],
            [['rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['rpn' => 'rpn']],
            [['author_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['author_rpn' => 'rpn']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'file_memo' => 'File Memo',
            'access_bit_id' => 'Access Bit ID',
            'rpn' => 'Rpn',
            'author_rpn' => 'Author Rpn',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessBit()
    {
        return $this->hasOne(AccessBit::className(), ['bit_pos' => 'access_bit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['rpn' => 'rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Staff::className(), ['rpn' => 'author_rpn']);
    }
}
