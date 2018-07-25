<?php

namespace app\models\forms;

use app\models\MedicineCheckup;
use app\models\MedicineCheckupInjury;
use mate\yii\models\form\UpdateToManyTrait;

/**
 * MedicineCheckupForm represents the form for the model `app\models\MedicineCheckup`.
 */
class MedicineCheckupForm extends MedicineCheckup
{

    use UpdateToManyTrait;

    public $injuriesData;

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

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['injuriesData'], 'safe']
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
                $injuryModel->checkup_id = $this->id;
                if ($injuryModel->save()) {
                    $injuryIds[] = $injuryModel->id;
                }
            } elseif ($injuryData instanceof MedicineCheckupInjury) {
                if ($injuryData->save()) {
                    $injuryIds[] = $injuryData->id;
                }
            }
        }
        return $injuryIds;
    }

    /**
     * @param mixed $key
     * @return bool|MedicineCheckupInjury
     */
    private function findInjury($key)
    {
        $injury = $key && strpos($key, 'new') === false ? MedicineCheckupInjury::findOne($key) : false;
        if (!$injury) {
            $injury = new MedicineCheckupInjury();
        }
        return $injury;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if (!parent::save($runValidation, $attributeNames)) {
            return false;
        }

        $this->updateToMany("injuries", MedicineCheckupInjury::class, $this->saveInjuries());

        return true;
    }

}