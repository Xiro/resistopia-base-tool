<?php

use yii\bootstrap\ActiveForm;
use app\helpers\Html;
use app\models\MedicineCheckupInjury;
use kartik\select2\Select2;

/** @var string $key */
/** @var ActiveForm $form */
/** @var \app\models\MedicineTreatmentInjury $injury */
?>

<?= $form->field($injury, 'id', [
    'options' => [
        'class' => 'hidden',
    ],
])->hiddenInput([
    'id'   => "MedicineTreatmentForm_injuriesData_{$key}_id",
    'name' => "MedicineTreatmentForm[injuriesData][{$key}][id]",
])->label(false) ?>

<?= $form->field($injury, 'x', [
    'options' => [
        'class' => 'hidden input-x',
    ],
])->hiddenInput([
    'id'    => "MedicineTreatmentForm_injuriesData_{$key}_x",
    'name'  => "MedicineTreatmentForm[injuriesData][{$key}][x]",
    'class' => "x-input"
])->label(false) ?>

<?= $form->field($injury, 'y', [
    'options' => [
        'class' => 'hidden input-y',
    ],
])->hiddenInput([
    'id'    => "MedicineTreatmentForm_injuriesData_{$key}_y",
    'name'  => "MedicineTreatmentForm[injuriesData][{$key}][y]",
    'class' => "y-input"
])->label(false) ?>

<div class="col-sm-4">
    <div class="form-group">
        <?= $form->field($injury, 'injury', [
            'labelOptions' => ['class' => 'move']
        ])->dropDownList([
            'Durchschuss' => 'Durchschuss',
            'Steckschuss' => 'Steckschuss',
            'Splitter'    => 'Splitter',
            'Verbrennung' => 'Verbrennung',
            'Schnitt'     => 'Schnitt',
            'Sonstiges'   => 'Sonstiges',
        ], [
            'showToggleAll' => false,
            'id'            => "MedicineTreatmentForm_injuriesData_{$key}_injury",
            'name'          => "MedicineTreatmentForm[injuriesData][$key][injury]",
            'class'         => 'form-control input-injury',
            'clientOptions' => [
                'id' => "injuriesData_{$key}_injury",
            ],
        ]) ?>
    </div>
</div>

<div class="col-sm-4">
    <div class="form-group">
        <?= $form->field($injury, 'operation', [
            'options' => [
                'class' => '',
            ],
        ])->textInput([
            'id'   => "MedicineTreatmentForm_injuriesData_{$key}_operation",
            'name' => "MedicineTreatmentForm[injuriesData][$key][operation]",
        ]); ?>
    </div>
</div>

<div class="col-sm-4">
    <div class="input-group form-group">
        <?= $form->field($injury, 'annotation', [
            'options' => [
                'class' => '',
            ],
        ])->textInput([
            'id'   => "MedicineTreatmentForm_injuriesData_{$key}_annotation",
            'name' => "MedicineTreatmentForm[injuriesData][$key][annotation]",
        ]); ?>
        <span class="input-group-btn">
    <?= Html::button(
        '<span class="glyphicon glyphicon-minus"></span>',
        ['class' => 'btn btn-default remove-injury-row']
    ) ?>
      </span>
    </div>
</div>