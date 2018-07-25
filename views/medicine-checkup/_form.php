<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use app\assets\page\MedicineFormAsset;
use app\models\MedicineCheckupInjury;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MedicineCheckupForm */
/* @var $form yii\bootstrap\ActiveForm */

MedicineFormAsset::register($this);

?>

<div class="medicine-checkup-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label", "id" => "medicine-checkup-form"],
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
                    <?= $this->render("_checkup-injury-form", [
                        "key"    => "__id__",
                        "form"   => $form,
                        "injury" => new MedicineCheckupInjury()
                    ]) ?>
                </div>
                <?php foreach ($model->injuries as $key => $injury): ?>
                    <div class="row injury-row" data-key="<?= $key ?>">
                        <?= $this->render("_checkup-injury-form", [
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

    <h4>Weitere Informationen</h4>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'nutrition', [
                'labelOptions' => ['class' => 'move']
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['Unauffällig' => 'Unauffällig', 'Unterernährt' => 'Unterernährt', 'Vitaminmangel' => 'Vitaminmangel',],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'psyche', [
                'labelOptions' => ['class' => 'move']
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['Unauffällig' => 'Unauffällig', 'Nicht beurteilbar' => 'Nicht beurteilbar', 'Psychiater informiert' => 'Psychiater informiert',],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'complexion')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'vaccinations')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'conditions')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'drug_use')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'other')->textarea(['rows' => 4]) ?>
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