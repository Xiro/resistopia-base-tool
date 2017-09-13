<?php

use yii\helpers\Url;
use kartik\select2\Select2;
use dosamigos\datetimepicker\DateTimePicker;
use app\helpers\ValMap;
use app\models\MissionType;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MissionCall */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="mission-call-form">

    <?php $form = ActiveForm::begin([
        'id'          => 'mission-call-form',
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <h3>Information</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'mission_type_id', [
                        'labelOptions' => ['class' => ($model->mission_type_id ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ValMap::model(MissionType::class, "id", "name"),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Type") ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'zone', [
                        'labelOptions' => ['class' => ($model->zone ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => [ 1 => '1', 2 => '2', 3 => '3', ],
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Zone") ?>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea([
                    'style' => "height: 117px"
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4>Schedule</h4>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'scheduled_start', [
                        'options' => ['class' => "form-group date-picker"],
                        'labelOptions' => ['class' => ($model->scheduled_start ? "move" : "")]
                    ])->widget(DateTimePicker::className(), [
                        'size' => 'sm',
                        'template' => '{input}',
                        'pickButtonIcon' => 'glyphicon glyphicon-time',
                        'clientOptions' => [
                            'type' => 'TYPE_BUTTON',
                            'startView' => 1,
                            'minView' => 0,
                            'maxView' => 1,
                            'autoclose' => true,
                            'linkFormat' => 'HH:ii P', // if inline = true
                            // 'format' => 'HH:ii P', // if inline = false
                            'todayBtn' => true
                        ]
                    ]);?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'scheduled_end', [
                        'options' => ['class' => "form-group date-picker"],
                        'labelOptions' => ['class' => ($model->scheduled_end ? "move" : "")]
                    ])->widget(DateTimePicker::className(), [
                        'size' => 'sm',
                        'template' => '{input}',
                        'pickButtonIcon' => 'glyphicon glyphicon-time',
                        'clientOptions' => [
                            'type' => 'TYPE_BUTTON',
                            'startView' => 1,
                            'minView' => 0,
                            'maxView' => 1,
                            'autoclose' => true,
                            'linkFormat' => 'HH:ii P', // if inline = true
                            // 'format' => 'HH:ii P', // if inline = false
                            'todayBtn' => true
                        ]
                    ]);?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h4>Rewards</h4>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'RP')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'FP')->textInput() ?>
                </div>
            </div>
        </div>
    </div>

    <h4>Requirements</h4>

    <div class="row">
        <div class="col-md-2" style="width: 14.286%">
            <?= $form->field($model, 'fighter')->textInput() ?>
        </div>
        <div class="col-md-2" style="width: 14.286%">
            <?= $form->field($model, 'radio')->textInput() ?>
        </div>
        <div class="col-md-2" style="width: 14.286%">
            <?= $form->field($model, 'medic')->textInput() ?>
        </div>
        <div class="col-md-2" style="width: 14.286%">
            <?= $form->field($model, 'technician')->textInput() ?>
        </div>
        <div class="col-md-2" style="width: 14.286%">
            <?= $form->field($model, 'science')->textInput() ?>
        </div>
        <div class="col-md-2" style="width: 14.286%">
            <?= $form->field($model, 'guard')->textInput() ?>
        </div>
        <div class="col-md-2" style="width: 14.286%">
            <?= $form->field($model, 'vip')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? "Create" : "Update",
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>