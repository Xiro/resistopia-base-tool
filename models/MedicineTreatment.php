<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "medicine_treatment".
 *
 * @property integer $id
 * @property string $author_sid
 * @property string $patient_sid
 * @property string $impairment
 * @property string $aftercare
 * @property string $operational_fitness
 * @property string $breathing
 * @property string $breathing_details
 * @property string $pupils
 * @property double $pulse
 * @property double $temperature
 * @property double $blood_pressure_systolic
 * @property double $blood_pressure_diastolic
 * @property string $psyche
 * @property string $pretreatment
 * @property string $medi_foam
 * @property string $annotation
 * @property string $created
 * @property string $updated
 * @property integer $mission_block_id
 *
 * @property Staff $author
 * @property MissionBlock $missionBlock
 * @property Staff $patient
 * @property MedicineTreatmentInjury[] $injuries
 * @property MedicineTreatmentMedication[] $medications
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
            [['author_sid', 'patient_sid', 'breathing', 'pupils'], 'required'],
            [['impairment', 'aftercare', 'operational_fitness', 'breathing', 'pupils', 'psyche', 'pretreatment', 'medi_foam', 'annotation'], 'string'],
            [['pulse', 'temperature', 'blood_pressure_systolic', 'blood_pressure_diastolic'], 'number'],
            [['created', 'updated'], 'safe'],
            [['author_sid', 'patient_sid'], 'string', 'max' => 8],
            [['breathing_details'], 'string', 'max' => 255],
            [['author_sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['author_sid' => 'sid']],
            [['mission_block_id'], 'exist', 'skipOnError' => true, 'targetClass' => MissionBlock::className(), 'targetAttribute' => ['mission_block_id' => 'id']],
            [['patient_sid'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['patient_sid' => 'sid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_sid' => 'Behandelnder Arzt',
            'patient_sid' => 'Patient',
            'impairment' => 'Dauerhafte Beeinträchtigung',
            'aftercare' => 'Notwendige Nachbehandlung',
            'operational_fitness' => 'Einsatztauglichkeit',
            'breathing' => 'Atmung',
            'breathing_details' => 'Atmung (Details)',
            'pupils' => 'Pupillen',
            'pulse' => 'Puls',
            'temperature' => 'Temperatur',
            'blood_pressure_systolic' => 'Blutdruck Sys.',
            'blood_pressure_diastolic' => 'Blutdruck Dia.',
            'psyche' => 'Psychisch Auffällig',
            'pretreatment' => 'Vorbehandlung',
            'medi_foam' => 'Medi Foam',
            'annotation' => 'Sonstige Anmerkungen',
            'created' => 'Erstellt',
            'updated' => 'Bearbeitet',
            'mission_block_id' => 'Missionsblock',
        ];
    }

    public function delete()
    {
        foreach ($this->injuries as $injury) {
            $injury->delete();
        }
        foreach ($this->medications as $medication) {
            $medication->delete();
        }
        return parent::delete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Staff::className(), ['sid' => 'author_sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMissionBlock()
    {
        return $this->hasOne(MissionBlock::className(), ['id' => 'mission_block_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Staff::className(), ['sid' => 'patient_sid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInjuries()
    {
        return $this->hasMany(MedicineTreatmentInjury::className(), ['treatment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedications()
    {
        return $this->hasMany(MedicineTreatmentMedication::className(), ['treatment_id' => 'id']);
    }
}
