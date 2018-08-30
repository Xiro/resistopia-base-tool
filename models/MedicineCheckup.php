<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medicine_checkup".
 *
 * @property integer $id
 * @property string $author_rpn
 * @property string $patient_rpn
 * @property string $impairment
 * @property string $aftercare
 * @property string $breathing
 * @property string $breathing_details
 * @property string $pupils
 * @property double $pulse
 * @property double $temperature
 * @property double $blood_pressure_systolic
 * @property double $blood_pressure_diastolic
 * @property string $nutrition
 * @property string $psyche
 * @property string $complexion
 * @property string $vaccinations
 * @property string $conditions
 * @property string $drug_use
 * @property string $other
 * @property string $created
 * @property string $updated
 *
 * @property Staff $author
 * @property Staff $patient
 * @property MedicineCheckupInjury[] $injuries
 */
class MedicineCheckup extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medicine_checkup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_rpn', 'patient_rpn', 'breathing', 'pupils', 'nutrition', 'psyche'], 'required'],
            [['impairment', 'aftercare', 'breathing', 'pupils', 'nutrition', 'psyche', 'complexion', 'vaccinations', 'conditions', 'drug_use', 'other'], 'string'],
            [['pulse', 'temperature', 'blood_pressure_systolic', 'blood_pressure_diastolic'], 'number'],
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
            'author_rpn' => 'Behandelnder Arzt',
            'patient_rpn' => 'Patient',
            'impairment' => 'Dauerhafte Beeinträchtigung',
            'aftercare' => 'Notwendige Nachbehandlung',
            'breathing' => 'Atmung',
            'breathing_details' => 'Atmung (Details)',
            'pupils' => 'Pupillen',
            'pulse' => 'Puls',
            'temperature' => 'Temperatur',
            'blood_pressure_systolic' => 'Blutdruck Sys.',
            'blood_pressure_diastolic' => 'Blutdruck Dia.',
            'psyche' => 'Psychisch Auffällig',
            'complexion' => 'Hautbild',
            'vaccinations' => 'Bekannte Impfungen',
            'conditions' => 'Vorerkrankungen/Infektionen/Allergien',
            'drug_use' => 'Medikamenten-/Drogenkonsum',
            'other' => 'Sonstige Anmerkungen',
            'created' => 'Erstellt',
            'updated' => 'Bearbeitet',
        ];
    }

    public function delete()
    {
        foreach ($this->injuries as $injury) {
            $injury->delete();
        }
        return parent::delete();
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
    public function getInjuries()
    {
        return $this->hasMany(MedicineCheckupInjury::className(), ['checkup_id' => 'id']);
    }
}
