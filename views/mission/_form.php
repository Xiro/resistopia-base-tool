<?php

use app\assets\page\MissionFormAsset;
use app\helpers\ValMap;
use app\models\MissionStatus;
use app\models\MissionType;
use app\models\Staff;
use app\models\Team;
use app\widgets\Glyphicon;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Operation;

MissionFormAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\form\MissionForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $staffSearch \app\models\search\StaffSearch */
/* @var $staffDataProvider \yii\data\ActiveDataProvider */
?>

<div class="mission-form">


    <?php $form = ActiveForm::begin([
        'id'          => 'index-search-form',
        "action"      => Url::to(["mission/search-staff"]),
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label",
            "data"             => [

            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>
    <?php ActiveForm::end(); ?>

    <?php $form = ActiveForm::begin([
        'id'          => 'mission-form',
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
                <div class="col-md-12">
                    <?php
                    $operationData = ArrayHelper::map(
                        Operation::find()
                            ->joinWith("missions")
                            ->where(["mission.mission_status_id" => MissionStatus::findOne(["name" => MissionStatus::STATUS_ACTIVE])->id])
                            ->orWhere(["mission.mission_status_id" => MissionStatus::findOne(["name" => MissionStatus::STATUS_PENDING])->id])
                            ->groupBy("operation.id")
                            ->all(),
                        "id",
                        "name"
                    );
                    if ($model->operation && !is_numeric($model->operation)) {
                        $operationData[$model->operation] = $model->operation;
                    }
                    ?>
                    <?= $form->field($model, 'operation', [
                        'labelOptions' => ['class' => ($model->operation ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => $operationData,
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags'       => true,
                        ],
                    ])->label("Operation") ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <?= $form->field($model, 'mission_status_id', [
                        'labelOptions' => ['class' => ($model->mission_status_id ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => ValMap::model(MissionStatus::class, "id", "name"),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label("Status") ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'zone', [
                        'labelOptions' => ['class' => ($model->zone ? "move" : "")]
                    ])->widget(Select2::classname(), [
                        'showToggleAll' => false,
                        'data'          => [1 => '1', 2 => '2', 3 => '3',],
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
                'style' => "height: 193px"
            ]) ?>
        </div>
    </div>
    <div class="row">
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
        <?php if (!$model->isNewRecord): ?>
            <div class="col-md-6">
                <?= $form->field($model, 'debrief_comment')->textarea([
                    'style' => "height: 124px"
                ]) ?>
            </div>
        <?php endif; ?>
    </div>

    <h4>Staff</h4>

    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered staff-table" id="index-search-table">
                <thead>
                <tr class="animated-label">
                    <th class="rpn">
                        <?= $form->field($staffSearch, 'rpn')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                    <th class="name">
                        <?= $form->field($staffSearch, 'name')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                    <th class="team">
                        <?= $form->field($staffSearch, 'team_id', [
                            'labelOptions' => ['class' => ($staffSearch->team_id ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(Team::class, "id", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'index-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Team") ?>
                    </th>
                    <th class="call-sign">
                        <?= $form->field($staffSearch, 'call_sign', [
                            'labelOptions' => ['class' => ($staffSearch->call_sign ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ArrayHelper::map(
                                Staff::find()->where("call_sign IS NOT NULL")->all(),
                                "call_sign",
                                "call_sign"
                            ),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'index-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("CS") ?>
                    </th>
                    <th class="actions" style="padding: 8px">
                        <?= Glyphicon::arrow_right(["class" => "list-btn add-all-staff"]) ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?= $this->render("_staff-list-table-body", [
                    "staffModels" => $staffDataProvider->getModels()
                ]); ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered staff-table" id="staff-selection-table">
                <thead>
                <tr>
                    <th class="rpn">
                        RPN
                    </th>
                    <th class="name">
                        Name
                    </th>
                    <th class="team">
                        Team
                    </th>
                    <th class="call-sign">
                        Call Sign
                    </th>
                    <th class="actions">
                        <?= Glyphicon::remove(["class" => "assigned-btn remove-all-staff"]) ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?= $this->render("_staff-list-table-body", [
                    "staffModels" => $model->getCombinedStaffModels(),
                    "checked" => true,
                ]); ?>
                </tbody>
            </table>
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