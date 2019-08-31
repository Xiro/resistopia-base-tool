<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\widgets\SelectData;
use yii\helpers\ArrayHelper;
use dosamigos\datetimepicker\DateTimePicker;
use app\models\MissionStatus;
use app\models\Staff;
use app\models\search\StaffSearch;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MissionForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="mission-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <h4>Information</h4>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <div class="col-sm-8 col-lg-9">
                    <?= $form->field($model, 'operation_id', [
                        'labelOptions' => ['class' => ($model->operation_id ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(app\models\Operation::class),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags'       => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-sm-4 col-lg-3">
                    <?= $form->field($model, 'zone', [
                        'labelOptions' => ['class' => ($model->zone ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => [1 => '1', 2 => '2', 3 => '3',],
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
                    <?= $form->field($model, 'mission_type_id', [
                        'labelOptions' => ['class' => ($model->mission_type_id ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(app\models\MissionType::class),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('Mission Type') ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'mission_status_id', [
                        'labelOptions' => ['class' => ($model->mission_status_id ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => SelectData::fromModel(MissionStatus::class),
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'description')->textarea(['style' => 'height: 193px']) ?>
        </div>
    </div>

    <h4>Schedule</h4>

    <div class="row">
        <div class="col-sm-6 col-md-3">
            <?= $form->field($model, 'time_lst', [
                'options'      => ['class' => "form-group date-picker"],
                'labelOptions' => ['class' => ($model->time_publish ? "move" : "")]
            ])->widget(DateTimePicker::class, [
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
                    'todayBtn'   => true
                ]
            ])->label('LST Limit of start time'); ?>
        </div>
        <div class="col-sm-6 col-md-3">
            <?= $form->field($model, 'time_ete', [
                'options'      => ['class' => "form-group date-picker"],
                'labelOptions' => ['class' => ($model->time_publish ? "move" : "")]
            ])->widget(DateTimePicker::class, [
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
                    'todayBtn'   => true
                ]
            ])->label('ETE Estimated time of execution'); ?>
        </div>
        <div class="col-sm-6 col-md-3">
            <?= $form->field($model, 'time_atf')->textInput(['class' => 'form-control mask-duration'])->label('ATF Accepted time favor') ?>
        </div>
        <div class="col-sm-6 col-md-3">
            <?= $form->field($model, 'time_publish', [
                'options'      => ['class' => "form-group date-picker"],
                'labelOptions' => ['class' => ($model->time_publish ? "move" : "")]
            ])->widget(DateTimePicker::class, [
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
                    'todayBtn'   => true
                ]
            ]); ?>
        </div>
    </div>

    <h4>Requirements</h4>

    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4">
            <?= $form->field($model, 'slots_radio')->textInput() ?>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4">
            <?= $form->field($model, 'slots_medic')->textInput() ?>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4">
            <?= $form->field($model, 'slots_tech')->textInput() ?>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4">
            <?= $form->field($model, 'slots_res')->textInput() ?>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4">
            <?= $form->field($model, 'slots_guard')->textInput() ?>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4">
            <?= $form->field($model, 'slots_vip')->textInput() ?>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4">
            <?= $form->field($model, 'slots_total')->textInput() ?>
        </div>
    </div>

    <h4>Staff</h4>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'mission_lead_sid', [
                'labelOptions' => ['class' => ($model->mission_lead_sid ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(Staff::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ]) ?>
        </div>
    </div>

    <?= $this->render('_staff-form', [
        'form'  => $form,
        'model' => $model,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>