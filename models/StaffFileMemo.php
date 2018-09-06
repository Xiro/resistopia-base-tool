<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "staff_file_memo".
 *
 * @property integer $id
 * @property string $file_memo_number
 * @property string $title
 * @property string $file_memo
 * @property integer $access_right_id
 * @property string $rpn
 * @property string $author_rpn
 * @property string $created
 * @property string $updated
 *
 * @property AccessRight $accessRight
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
            [['access_right_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['file_memo_number'], 'string', 'max' => 16],
            [['file_memo_number'], 'unique'],
            [['title'], 'string', 'max' => 50],
            [['rpn', 'author_rpn'], 'string', 'max' => 8],
            [['access_right_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessRight::className(), 'targetAttribute' => ['access_right_id' => 'id']],
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
            'file_memo_number' => 'File Memo Nr',
            'title' => 'Title',
            'file_memo' => 'File Memo',
            'access_right_id' => 'Access Right ID',
            'rpn' => 'Rpn',
            'author_rpn' => 'Author Rpn',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord) {
            $lastId = self::find()
                ->select(['max(id) as last_id'])
                ->asArray()
                ->one();
            $lastId = $lastId ? $lastId['last_id'] : 0;
            $nextId = $lastId + 1;
            $this->file_memo_number = $this->rpn . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessRight()
    {
        return $this->hasOne(AccessRight::className(), ['id' => 'access_right_id']);
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
