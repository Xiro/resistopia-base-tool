<?php

namespace app\models\forms;

use app\models\MedicineDrug;
use app\models\MedicineTreatmentMedication;
use mate\yii\models\form\UpdateDynamicToOneTrait;

/**
 * MedicineTreatmentMedication represents the form for the model `app\models\MedicineTreatmentMedication`.
 */
class MedicineTreatmentMedicationForm extends MedicineTreatmentMedication
{

    use UpdateDynamicToOneTrait;

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

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->updateToOne('drug', [
            'creationAttributes' => [
                'order' => MedicineDrug::find()->count() + 1
            ]
        ]);
        return parent::save($runValidation, $attributeNames);
    }

}