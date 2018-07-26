<?php

namespace app\models\forms;

use app\models\MedicineTreatment;
use app\models\MedicineTreatmentInjury;
use app\models\MedicineTreatmentMedication;
use app\models\MissionBlock;
use mate\yii\models\form\UpdateDynamicToOneTrait;
use mate\yii\models\form\UpdateToManyTrait;

/**
 * MedicineTreatmentForm represents the form for the model `app\models\MedicineTreatment`.
 */
class MedicineTreatmentForm extends MedicineTreatment
{

    use UpdateToManyTrait;
    use UpdateDynamicToOneTrait;

    public $injuriesData;
    public $medicationData;
    public $mission_block_time;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        if($this->mission_block_id) {
            $this->mission_block_time = date('Y-m-d H:i', strtotime($this->missionBlock->unblock_time));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['injuriesData', 'medicationData', 'mission_block_time'], 'safe']
        ]);
    }

    private function saveInjuries()
    {
        $injuryIds = [];
        foreach ($this->injuriesData as $key => $injuryData) {
            if (is_array($injuryData)) {
                if (empty($injuryData["injury"]) && empty($injuryData["annotation"])) {
                    continue;
                }
                $key = isset($injuryData["id"]) && !empty($injuryData["id"]) ? $injuryData["id"] : $key;
                $injuryModel = $this->findInjury($key);
                $injuryModel->setAttributes($injuryData);
                $injuryModel->treatment_id = $this->id;
                if ($injuryModel->save()) {
                    $injuryIds[] = $injuryModel->id;
                }
            } elseif ($injuryData instanceof MedicineTreatmentInjury) {
                if ($injuryData->save()) {
                    $injuryIds[] = $injuryData->id;
                }
            }
        }
        return $injuryIds;
    }

    /**
     * @param mixed $key
     * @return bool|MedicineTreatmentInjury
     */
    private function findInjury($key)
    {
        $injury = $key && strpos($key, 'new') === false ? MedicineTreatmentInjury::findOne($key) : false;
        if (!$injury) {
            $injury = new MedicineTreatmentInjury();
        }
        return $injury;
    }

    private function saveMedications()
    {
        $medicationIds = [];
        foreach ($this->medicationData as $key => $medicationData) {
            if (is_array($medicationData)) {
                if (empty($medicationData["location"]) && empty($medicationData["drug_id"])) {
                    continue;
                }
                $key = isset($medicationData["id"]) && !empty($medicationData["id"]) ? $medicationData["id"] : $key;
                $medicationModel = $this->findMedication($key);
                $medicationModel->setAttributes($medicationData);
                $medicationModel->treatment_id = $this->id;
                if ($medicationModel->save()) {
                    $medicationIds[] = $medicationModel->id;
                }
            } elseif ($medicationData instanceof MedicineTreatmentMedication) {
                if ($medicationData->save()) {
                    $medicationIds[] = $medicationData->id;
                }
            }
        }
        return $medicationIds;
    }

    /**
     * @param mixed $key
     * @return bool|MedicineTreatmentInjury
     */
    private function findMedication($key)
    {
        $medication = $key && strpos($key, 'new') === false ? MedicineTreatmentMedicationForm::findOne($key) : false;
        if (!$medication) {
            $medication = new MedicineTreatmentMedicationForm();
        }
        return $medication;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if (!parent::save($runValidation, $attributeNames)) {
            return false;
        }

        $this->updateToMany("injuries", MedicineTreatmentInjury::class, $this->saveInjuries());
        $this->updateToMany("medications", MedicineTreatmentMedication::class, $this->saveMedications());

        $missionBlock = $this->mission_block_id ? $this->missionBlock : new MissionBlock();
        if(!empty($this->mission_block_time)) {
            $missionBlock->unblock_time = $this->mission_block_time;
            $missionBlock->blocked_staff_member_rpn = $this->patient_rpn;
            $missionBlock->blocked_by_rpn = $this->author_rpn;
            $missionBlock->save();
            $this->mission_block_id = $missionBlock->id;
            parent::save($runValidation, $attributeNames);
        } elseif($this->mission_block_id) {
            $this->mission_block_id = null;
            parent::save($runValidation, $attributeNames);
            $missionBlock->delete();
        }

        return true;
    }

}