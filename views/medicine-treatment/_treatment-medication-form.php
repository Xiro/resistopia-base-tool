<?php

use yii\bootstrap\ActiveForm;
use app\helpers\Html;
use mate\yii\widgets\SelectData;
use app\models\MedicineDrug;

/** @var string $key */
/** @var ActiveForm $form */
/** @var \app\models\MedicineTreatmentInjury $medication */
?>

<?= $form->field($medication, 'id', [
    'options' => [
        'class' => 'hidden',
    ],
])->hiddenInput([
    'id'   => "MedicineTreatmentForm_medicationData_{$key}_id",
    'name' => "MedicineTreatmentForm[medicationData][{$key}][id]",
])->label(false) ?>

<div class="col-sm-6">
    <div class="form-group">
        <?= $form->field($medication, 'location', [
            'labelOptions' => ['class' => 'move']
        ])->dropDownList([
            'Stationär' => 'Stationär',
            'Im Feld'   => 'Im Feld',
        ], [
            'showToggleAll' => false,
            'id'            => "MedicineTreatmentForm_medicationData_{$key}_location",
            'name'          => "MedicineTreatmentForm[medicationData][$key][location]",
            'class'         => 'form-control select2 select-location',
            'clientOptions' => [
                'id' => "medicationData_{$key}_location",
            ],
        ]) ?>
    </div>
</div>

<div class="col-sm-6">
    <div class="input-group form-group">
        <?= $form->field($medication, 'drug_id', [
            'labelOptions' => ['class' => 'move']
        ])->dropDownList(SelectData::fromModel(MedicineDrug::class), [
            'showToggleAll' => false,
            'id'            => "MedicineTreatmentForm_medicationData_{$key}_drug_id",
            'name'          => "MedicineTreatmentForm[medicationData][$key][drug_id]",
            'class'         => 'form-control select2 select-drug',
            'clientOptions' => [
                'id' => "medicationData_{$key}_drug_id",
            ],
        ]) ?>
        <span class="input-group-btn">
    <?= Html::button(
        '<span class="glyphicon glyphicon-minus"></span>',
        ['class' => 'btn btn-default remove-medication-row']
    ) ?>
      </span>
    </div>
</div>