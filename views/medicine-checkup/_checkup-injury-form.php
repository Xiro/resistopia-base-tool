<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\MedicineCheckupInjury;
use kartik\select2\Select2;

/** @var string $key */
/** @var ActiveForm $form */
/** @var MedicineCheckupInjury $injury */
?>

<?= $form->field($injury, 'id', [
    'options' => [
        'class' => 'hidden',
    ],
])->hiddenInput([
    'id'   => "MedicineCheckupForm_injuriesData_{$key}_id",
    'name' => "MedicineCheckupForm[injuriesData][{$key}][id]",
])->label(false) ?>

<?= $form->field($injury, 'x', [
    'options' => [
        'class' => 'hidden input-x',
    ],
])->hiddenInput([
    'id'    => "MedicineCheckupForm_injuriesData_{$key}_x",
    'name'  => "MedicineCheckupForm[injuriesData][{$key}][x]",
    'class' => "x-input"
])->label(false) ?>

<?= $form->field($injury, 'y', [
    'options' => [
        'class' => 'hidden input-y',
    ],
])->hiddenInput([
    'id'    => "MedicineCheckupForm_injuriesData_{$key}_y",
    'name'  => "MedicineCheckupForm[injuriesData][{$key}][y]",
    'class' => "y-input"
])->label(false) ?>

<div class="col-sm-6">
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
            'id'            => "MedicineCheckupForm_injuriesData_{$key}_injury",
            'name'          => "MedicineCheckupForm[injuriesData][$key][injury]",
            'class'         => 'form-control input-injury',
            'clientOptions' => [
                'id' => "injuriesData_{$key}_injury",
            ],
        ]) ?>
    </div>
</div>

<div class="col-sm-6">
    <div class="input-group form-group">
        <?= $form->field($injury, 'annotation', [
            'options' => [
                'class' => '',
            ],
        ])->textInput([
            'id'   => "MedicineCheckupForm_injuriesData_{$key}_annotation",
            'name' => "MedicineCheckupForm[injuriesData][$key][annotation]",
        ]); ?>
        <span class="input-group-btn">
    <?= Html::button(
        '<span class="glyphicon glyphicon-minus"></span>',
        ['class' => 'btn btn-default remove-injury-row']
    ) ?>
      </span>
    </div>
</div>