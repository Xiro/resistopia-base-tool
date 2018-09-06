<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use app\assets\page\MedicineFormAsset;
use app\models\MedicineTreatmentInjury;
use app\models\MedicineTreatmentMedication;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MedicineTreatmentForm */
/* @var $form yii\bootstrap\ActiveForm */

MedicineFormAsset::register($this);
?>

<div class="medicine-treatment-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label", "id" => "medicine-form"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'patient_rpn', [
                'labelOptions' => ['class' => ($model->patient_rpn ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(
                    app\models\Staff::class,
                    'rpn',
                    'nameWithRpn',
                    true
                ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
    </div>

    <h4>Diagnostik</h4>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'impairment')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'aftercare')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'operational_fitness', [
                'labelOptions' => ['class' => 'move']
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['tauglich' => 'Tauglich', 'eingeschränkt tauglich' => 'Eingeschränkt tauglich', 'gesperrt' => 'Gesperrt',],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <div id="mission-block-time" class="<?= $model->operational_fitness == "gesperrt" ? '' : 'hidden' ?>">
                <?= $form->field($model, 'mission_block_time', [
                    'options'      => ['class' => "form-group date-picker"],
                    'labelOptions' => ['class' => ($model->mission_block_time ? "move" : "")]
                ])->widget(\dosamigos\datetimepicker\DateTimePicker::className(), [
                    'size'           => 'sm',
                    'template'       => '{input}',
                    'pickButtonIcon' => 'glyphicon glyphicon-time',
                    'clientOptions'  => [
                        'type'       => 'TYPE_BUTTON',
                        'startView'  => 1,
                        'minView'    => 0,
                        'maxView'    => 1,
                        'autoclose'  => true,
                        'linkFormat' => 'HH:ii P', // if inline = true
                        // 'format' => 'HH:ii P', // if inline = false
                    ]
                ])->label('Gesperrt bis'); ?>

                <?= $form->field($model, 'mission_block_reason')->textarea(['rows' => 3]) ?>
            </div>
        </div>
    </div>

    <?php $this->registerJs("activateMissionBlockTrigger()") ?>

    <h4>Verletzungen</h4>

    <div class="row">
        <div class="col-sm-4 text-center">
            <div class="injury-select-img">
                <?= Html::img(Yii::getAlias('@web/img/human-silhouette_600.png'), [
                    'class' => '',
                ]); ?>
                <?php foreach ($model->injuries as $key => $injury): ?>
                    <div class="injury-mark" style="top:<?= $injury->y ?>%;left:<?= $injury->x ?>%">
                        <span class="glyphicon glyphicon-screenshot"></span>
                        <span class="badge"></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="injury-rows">
                <div class="row injury-row injury-row-template" style="display: none" data-key="__id__" data-mark="">
                    <?= $this->render("_treatment-injury-form", [
                        "key"    => "__id__",
                        "form"   => $form,
                        "injury" => new MedicineTreatmentInjury()
                    ]) ?>
                </div>
                <?php foreach ($model->injuries as $key => $injury): ?>
                    <div class="row injury-row" data-key="<?= $key ?>">
                        <?= $this->render("_treatment-injury-form", [
                            "key"    => $key,
                            "form"   => $form,
                            "injury" => $injury
                        ]) ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

    <?php $this->registerJs("setupInjuriesAfterActiveForm()") ?>

    <h4>Vitalwerte</h4>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'breathing', [
                'labelOptions' => ['class' => 'move']
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['Unauffällig' => 'Unauffällig', 'Auffällig' => 'Auffällig',],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'breathing_details')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'pupils', [
                'labelOptions' => ['class' => 'move']
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['Normal' => 'Normal', 'Eng' => 'Eng', 'Erweitert' => 'Erweitert',],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'pulse')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'temperature')->textInput() ?>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'blood_pressure_systolic')->textInput() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'blood_pressure_diastolic')->textInput() ?>
                </div>
            </div>
        </div>
    </div>

    <h4>Behandlung</h4>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'pretreatment', [
                'labelOptions' => ['class' => 'move']
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['Keine' => 'Keine', 'CM' => 'CM', 'FM' => 'FM',]
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'medi_foam', [
                'labelOptions' => ['class' => 'move']
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['Kein' => 'Kein', 'MK 1' => 'MK 1', 'MK 2' => 'MK 2', 'Injektor' => 'Injektor',]
            ]) ?>
        </div>
    </div>

    <h4>Medikation</h4>

    <div class="medication-rows">
        <div class="row medication-row medication-row-template" style="display: none" data-key="__id__" data-mark="">
            <?= $this->render("_treatment-medication-form", [
                "key"        => "__id__",
                "form"       => $form,
                "medication" => new MedicineTreatmentMedication()
            ]) ?>
        </div>
        <?php foreach ($model->medications as $key => $medication): ?>
            <div class="row medication-row" data-key="<?= $key ?>">
                <?= $this->render("_treatment-medication-form", [
                    "key"        => $key,
                    "form"       => $form,
                    "medication" => $medication
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-6">
            <div class="form-group">
                <?= Html::button(
                    Glyphicon::plus() . ' &nbsp; Medikation hinzufügen',
                    ['class' => 'btn btn-primary new-medication-row', "style" => "width: 100%"]
                ) ?>
            </div>
        </div>
    </div>

    <?php $this->registerJs("setupMedicationsAfterActiveForm()") ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'annotation')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>