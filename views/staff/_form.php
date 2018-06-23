<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datetimepicker\DateTimePicker;
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
            <?= $form->field($model, 'forename')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'nickname')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'gender', [
                'labelOptions' => ['class' => ($model->gender ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => [ 'm' => 'Male', 'f' => 'Female', ],
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
                    'class' => 'form-control mask-date ',
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
            <?= $form->field($model, 'profession')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
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
                    'tags' => true,
                ],
            ])->label('Team') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'company_id', [
                'labelOptions' => ['class' => ($model->company_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\Company::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                ],
            ])->label('Company') ?>
        </div>
    </div>

    <div class="row">
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
        <div class="col-sm-6">
            <?= $form->field($model, 'base_category_id', [
                'labelOptions' => ['class' => ($model->base_category_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\BaseCategory::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Base Category') ?>
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
                    'tags' => true,
                ],
            ])->label('Citizenship') ?>
        </div>
    </div>


    <h3>System</h3>



    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'status_be13')->checkbox()->label('Currently serving in in BE13') ?>
            <?= $form->field($model, 'status_alive')->checkbox()->label('Is Alive') ?>
            <?= $form->field($model, 'status_it')->checkbox()->label('Is IT') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'callsign')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
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