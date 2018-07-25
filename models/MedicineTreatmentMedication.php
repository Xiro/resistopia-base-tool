<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medicine_treatment_medication".
 *
 * @property integer $id
 * @property integer $treatment_id
 * @property string $location
 * @property integer $drug_id
 *
 * @property MedicineDrug $drug
 * @property MedicineTreatment $treatment
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
            [['treatment_id', 'location'], 'required'],
            [['treatment_id'], 'integer'],
            [['location'], 'string'],
            [['drug_id'], 'exist', 'skipOnError' => true, 'targetClass' => MedicineDrug::className(), 'targetAttribute' => ['drug_id' => 'id']],
            [['treatment_id'], 'exist', 'skipOnError' => true, 'targetClass' => MedicineTreatment::className(), 'targetAttribute' => ['treatment_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'treatment_id' => 'Treatment ID',
            'location' => 'Behandlung',
            'drug_id' => 'Medikament',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrug()
    {
        return $this->hasOne(MedicineDrug::className(), ['id' => 'drug_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreatment()
    {
        return $this->hasOne(MedicineTreatment::className(), ['id' => 'treatment_id']);
    }
}
