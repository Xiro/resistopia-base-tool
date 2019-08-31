<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property string $name
 * @property string $section
 * @property string $department
 * @property string $group
 * @property string $key
 * @property integer $access_mask_id
 * @property integer $order
 *
 * @property AccessMask $accessMask
 * @property Staff[] $staff
 */
class Section extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section', 'department', 'group', 'key'], 'required'],
            [['access_mask_id', 'order'], 'integer'],
            [['section', 'department', 'group', 'key'], 'string', 'max' => 50],
            [['access_mask_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessMask::className(), 'targetAttribute' => ['access_mask_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section' => 'Section',
            'department' => 'Department',
            'group' => 'Group',
            'key' => 'Key',
            'access_mask_id' => 'Access Mask ID',
            'order' => 'Order',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if($this->isNewRecord) {
            $this->key = Inflector::camel2id(Inflector::camelize($this->section)) . "_";
            $this->key .= Inflector::camel2id(Inflector::camelize(str_replace("&", "and", $this->department)));
        }
        return parent::save($runValidation, $attributeNames);
    }


    public function getName()
    {
        return $this->section . " - " . $this->department;
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        foreach ($this->staff as $staff) {
            $staff->unlink('section', $this);
        }
        return parent::delete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessMask()
    {
        return $this->hasOne(AccessMask::className(), ['id' => 'access_mask_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['section_id' => 'id']);
    }
}
