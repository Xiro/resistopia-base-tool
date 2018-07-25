<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medicine_treatment".
 *
 * @property integer $id
 * @property string $author_rpn
 * @property string $patient_rpn
 * @property string $impairment
 * @property string $aftercare
 * @property string $operational_fitness
 * @property string $breathing
 * @property string $breathing_details
 * @property string $pupils
 * @property integer $pulse
 * @property integer $temperature
 * @property integer $blood_pressure_systolic
 * @property integer $blood_pressure_diastolic
 * @property string $psyche
 * @property string $pretreatment
 * @property string $medi_foam
 * @property string $annotation
 * @property string $created
 * @property string $updated
 *
 * @property Staff $author
 * @property Staff $patient
 * @property MedicineTreatmentInjury[] $medicineTreatmentInjuries
 */
class MedicineTreatment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicine_treatment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_rpn', 'patient_rpn', 'breathing', 'pupils'], 'required'],
            [['impairment', 'aftercare', 'operational_fitness', 'breathing', 'pupils', 'psyche', 'pretreatment', 'medi_foam', 'annotation'], 'string'],
            [['pulse', 'temperature', 'blood_pressure_systolic', 'blood_pressure_diastolic'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['author_rpn', 'patient_rpn'], 'string', 'max' => 8],
            [['breathing_details'], 'string', 'max' => 255],
            [['author_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['author_rpn' => 'rpn']],
            [['patient_rpn'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['patient_rpn' => 'rpn']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_rpn' => 'Author Rpn',
            'patient_rpn' => 'Patient Rpn',
            'impairment' => 'Impairment',
            'aftercare' => 'Aftercare',
            'operational_fitness' => 'Operational Fitness',
            'breathing' => 'Breathing',
            'breathing_details' => 'Breathing Details',
            'pupils' => 'Pupils',
            'pulse' => 'Pulse',
            'temperature' => 'Temperature',
            'blood_pressure_systolic' => 'Blood Pressure Systolic',
            'blood_pressure_diastolic' => 'Blood Pressure Diastolic',
            'psyche' => 'Psyche',
            'pretreatment' => 'Pretreatment',
            'medi_foam' => 'Medi Foam',
            'annotation' => 'Annotation',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Staff::className(), ['rpn' => 'author_rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Staff::className(), ['rpn' => 'patient_rpn']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicineTreatmentInjuries()
    {
        return $this->hasMany(MedicineTreatmentInjury::className(), ['treatment_id' => 'id']);
    }
}
