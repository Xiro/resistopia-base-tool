<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
/* @var $model app\models\StaffForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'rpn')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'forename')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'gender', [
                'labelOptions' => ['class' => ($model->gender ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => [ 'm' => 'M', 'f' => 'F', ],
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'date_of_birth')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'profession')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'callsign')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'height')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status_it')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status_be13')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status_alive')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status_in_base')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'squat_number')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'access_key_id', [
                'labelOptions' => ['class' => ($model->access_key_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ValMap::model(
                         app\models\AccessKey::class,
                         'id', 
                         'id'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Access Key') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'rank_id', [
                'labelOptions' => ['class' => ($model->rank_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ValMap::model(
                         app\models\Rank::class,
                         'id', 
                         'name'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Rank') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'base_category_id', [
                'labelOptions' => ['class' => ($model->base_category_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ValMap::model(
                         app\models\BaseCategory::class,
                         'id', 
                         'name'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Base Category') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'special_function_id', [
                'labelOptions' => ['class' => ($model->special_function_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ValMap::model(
                         app\models\SpecialFunction::class,
                         'id', 
                         'name'
                     ),
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
        <div class="col-md-6">
            <?= $form->field($model, 'company_id', [
                'labelOptions' => ['class' => ($model->company_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ValMap::model(
                         app\models\Company::class,
                         'id', 
                         'name'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Company') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'citizenship_id', [
                'labelOptions' => ['class' => ($model->citizenship_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ValMap::model(
                         app\models\Citizenship::class,
                         'id', 
                         'name'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Citizenship') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'eye_color_id', [
                'labelOptions' => ['class' => ($model->eye_color_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ValMap::model(
                         app\models\EyeColor::class,
                         'id', 
                         'name'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Eye Color') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'team_id', [
                'labelOptions' => ['class' => ($model->team_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ValMap::model(
                         app\models\Team::class,
                         'id', 
                         'name'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Team') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'created')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'updated')->textInput() ?>
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