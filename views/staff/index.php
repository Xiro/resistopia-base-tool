<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $search \app\models\search\StaffSearch */

use app\assets\page\StaffSearchAsset;
use app\helpers\ValMap;
use app\models\Category;
use app\models\Speciality;
use app\models\Team;
use app\models\StaffStatus;
use app\models\Staff;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

StaffSearchAsset::register($this);

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="staff-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> Add Staff Member",
                ["create"],
                ["class" => "btn btn-success ajax-dialog"]
            ); ?>
            </span>
        </h1>

        <div class="">
            <?php $form = ActiveForm::begin([
                'id'          => 'staff-search-form',
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

            <table class="table table-bordered" id="staff-table">
                <thead>
                <tr class="animated-label">
                    <th>
                        <?= $form->field($search, 'rpn')->textInput(["form" => "staff-search-form"]) ?>
                    </th>
                    <th>
                        <?= $form->field($search, 'name')->textInput(["form" => "staff-search-form"]) ?>
                    </th>
                    <th style="min-width: 150px">
                        <?= $form->field($search, 'category_id', [
                            'labelOptions' => ['class' => ($search->category_id ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(Category::class, "id", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'staff-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Category") ?>
                    </th>
                    <th style="min-width: 160px">
                        <?= $form->field($search, 'speciality_id', [
                            'labelOptions' => ['class' => ($search->speciality_id ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(Speciality::class, "id", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'staff-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Speciality") ?>
                    </th>
                    <th style="min-width: 160px">
                        <?= $form->field($search, 'team_id', [
                            'labelOptions' => ['class' => ($search->team_id ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(Team::class, "id", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'staff-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Team") ?>
                    </th>
                    <th style="min-width: 100px">
                        <?= $form->field($search, 'staff_status_id', [
                            'labelOptions' => ['class' => ($search->staff_status_id ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ValMap::model(StaffStatus::class, "id", "name"),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'staff-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Status") ?>
                    </th>
                    <th style="min-width: 110px">
                        <?= $form->field($search, 'call_sign', [
                            'labelOptions' => ['class' => ($search->call_sign ? "move" : "")]
                        ])->widget(Select2::classname(), [
                            'showToggleAll' => false,
                            'data'          => ArrayHelper::map(
                                Staff::find()->where("call_sign IS NOT NULL")->all(),
                                "call_sign",
                                "call_sign"
                            ),
                            'options'       => [
                                'placeholder' => '',
                                'form'        => 'staff-search-form',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Call Sign") ?>
                    </th>
                    <th>
                        <?php
//                        echo Html::button("Clear", [
//                            "class" => "btn btn-default search-clear",
//                            "style" => "width: 100%",
//                        ])
                        ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?= $this->render("_staff-table-body", [
                    "staffModels" => $dataProvider->getModels()
                ]); ?>
                </tbody>
            </table>

        </div>
    </div>
</div>