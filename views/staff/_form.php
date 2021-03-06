<?php

use app\helpers\Html;
use app\models\AccessMask;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;

/* @var $this yii\web\View */
/* @var $model app\models\forms\StaffForm */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="staff-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>


    <h3>Personal Information</h3>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'forename')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'gender', [
                'labelOptions' => ['class' => ($model->gender ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ['m' => 'Male', 'f' => 'Female',],
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'date_of_birth')->textInput([
                'class'        => 'form-control mask-date ',
                'autocomplete' => 'off'
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'height')->textInput(['autocomplete' => 'off']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'eye_color_id', [
                'labelOptions' => ['class' => ($model->eye_color_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\EyeColor::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Eye Color') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'profession')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'blood_type_id', [
                'labelOptions' => ['class' => ($model->blood_type_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\BloodType::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Blood Type') ?>
        </div>
    </div>


    <h3>Affiliation</h3>


    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'team_id', [
                'labelOptions' => ['class' => ($model->team_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Team::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ])->label('Team') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'special_function_id', [
                'labelOptions' => ['class' => ($model->special_function_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\SpecialFunction::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Special Function') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'section_id', [
                'labelOptions' => ['class' => ($model->section_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Section::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Section') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'citizenship_id', [
                'labelOptions' => ['class' => ($model->citizenship_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Citizenship::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ])->label('Citizenship') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'rank_id', [
                'labelOptions' => ['class' => ($model->rank_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Rank::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Rank') ?>
        </div>
    </div>


    <h3>System</h3>


    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'registered')->textInput([
                'class'        => 'form-control mask-date ',
                'autocomplete' => 'off'
            ])->label("Registered*") ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'resistance_cell_id', [
                'labelOptions' => ['class' => ($model->resistance_cell_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\ResistanceCell::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ])->label('First registered at*') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'callsign')->textInput([
                'maxlength' => true,
                'class'     => 'form-control mask-callsign'
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'status_alive')->checkbox([
                'template' => '<div class="checkbox">{beginLabel}{input}<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{labelTitle}{endLabel}{error}{hint}</div>',
            ])->label('Is Alive') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">

            <?php if (\app\components\Access::to('staff/grant-rights')): ?>
                <?= $form->field($model, 'accessMasks', [
                    'labelOptions' => ['class' => ($model->accessMasks ? 'move' : '')]
                ])->widget(Select2::class, [
                    'showToggleAll' => false,
                    'data'          => SelectData::fromModel(app\models\AccessMask::class),
                    'options'       => [
                        'placeholder' => '',
                    ],
                    'pluginOptions' => [
                        'allowClear'    => true,
                        'tags'          => true,
                        'multiple'      => true,
                        'closeOnSelect' => false,
                    ],
                ])->label('Access Masks') ?>
            <?php endif; ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ["class" => "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>