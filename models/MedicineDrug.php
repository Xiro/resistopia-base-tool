<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medicine_drug".
 *
 * @property integer $id
 * @property string $name
 * @property integer $order
 *
 * @property MedicineTreatmentMedication[] $medicineTreatmentMedications
 */
class MedicineDrug extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicine_drug';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['order'], 'integer'],
            [['name'], 'string', 'max' => 128],
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
    public function getMedicineTreatmentMedications()
    {
        return $this->hasMany(MedicineTreatmentMedication::className(), ['drug_id' => 'id']);
    }
}
