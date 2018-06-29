<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $order
 *
 * @property AccessRight[] $accessRights
 */
class AccessCategory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'order'], 'required'],
            [['order'], 'integer'],
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
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessRights()
    {
        return $this->hasMany(AccessRight::className(), ['access_category_id' => 'id']);
    }

    public function getAccessRightsCheckboxList()
    {
        $accessRights = $this->getAccessRights()->asArray()->all();
        $checkboxList = array_combine(
            array_column($accessRights, "id"),
            array_column($accessRights, "name")
        );
        return $checkboxList;
    }

}
