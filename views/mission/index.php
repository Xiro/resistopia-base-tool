<?php

use app\helpers\ValMap;
use app\models\MissionStatus;
use app\models\MissionType;
use dosamigos\datetimepicker\DateTimePicker;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $search \app\models\search\MissionSearch */

$this->title = 'Missions';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mission-index">
    <div class="container">


        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> Create Mission",
                ["create"],
                ["class" => "btn btn-primary ajax-dialog"]
            ); ?>
            </span>
        </h1>

        <div class="">
            <?php $form = ActiveForm::begin([
                'id'          => 'index-search-form',
                "action"      => Url::to(["staff/search"]),
                "options"     => [
                    'clientValidation' => false,
                    "class"            => "animated-label",
                    "data"             => [

                    ]
                ],
                "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
            ]); ?>
            <?php ActiveForm::end(); ?>

            <table class="table table-bordered mission-table" id="index-search-table">
                <thead>
                <tr class="animated-label">
                    <th class="name">
                        <?= $form->field($search, 'name')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                    <th class="mission-status">
                        <?= $form->field($search, 'mission_status_id', [
                            'labelOptions' => ['class' => ($search->mission_status_id ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(MissionStatus::class, "id", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'index-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Status") ?>
                    </th>
                    <th class="mission-type">
                        <?= $form->field($search, 'mission_type_id', [
                            'labelOptions' => ['class' => ($search->mission_type_id ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(MissionType::class, "id", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'index-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Type") ?>
                    </th>
                    <th class="zone">
                        <?= $form->field($search, 'zone', [
                            'labelOptions' => ['class' => ($search->zone ? "move" : "")]
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
                    </th>
                    <th class="description">
                        <?= $form->field($search, 'description')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                    <th class="debrief-comment">
                        <?= $form->field($search, 'debrief_comment')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                    <th class="rp">
                        <?= $form->field($search, 'RP')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                    <th class="fp">
                        <?= $form->field($search, 'FP')->textInput(["form" => "index-search-form"]) ?>
                    </th>
                    <th class="started">
                        <?= $form->field($search, 'started', [
                            'options' => ['class' => "form-group date-picker"],
                            'labelOptions' => ['class' => ($search->started ? "move" : "")]
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
                    </th>
                    <th class="ended">
                        <?= $form->field($search, 'ended', [
                            'options' => ['class' => "form-group date-picker"],
                            'labelOptions' => ['class' => ($search->ended ? "move" : "")]
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
                    </th>
                    <th class="actions"></th>
                </tr>
                </thead>
                <tbody>
                <?= $this->render("_mission-table-body", [
                    "missionModels" => $dataProvider->getModels()
                ]) ?>
                </tbody>
            </table>


        </div>
    </div>
</div>