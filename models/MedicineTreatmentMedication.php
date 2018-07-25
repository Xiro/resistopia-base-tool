<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medicine_treatment_medication".
 *
 * @property integer $id
 * @property integer $drug_id
 * @property string $location
 *
 * @property MedicineDrug $drug
 */
class MedicineTreatmentMedication extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicine_treatment_medication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drug_id', 'location'], 'required'],
            [['drug_id'], 'integer'],
            [['location'], 'string'],
            [['drug_id'], 'exist', 'skipOnError' => true, 'targetClass' => MedicineDrug::className(), 'targetAttribute' => ['drug_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'drug_id' => 'Drug ID',
            'location' => 'Location',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrug()
    {
        return $this->hasOne(MedicineDrug::className(), ['id' => 'drug_id']);
    }
}
