<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "operation".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Mission[] $missions
 */
class Operation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissions()
    {
        return $this->hasMany(Mission::className(), ['operation_id' => 'id']);
    }
}
