<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Team */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $staffSearch \app\models\search\StaffSearch */
/* @var $staffDataProvider \yii\data\ActiveDataProvider */
?>

<div class="team-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'comment')->textarea(['style' => "height: 117px"]) ?>
        </div>
    </div>

    <h4>Staff</h4>

    <?php $form = ActiveForm::begin([
        'id'          => 'index-search-form',
        "action"      => Url::to(["team/search-staff"]),
        "options"     => [
            'clientValidation' => false,
            "class"            => "animated-label",
            "data"             => [

            ]
        ],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>
    <?php ActiveForm::end(); ?>

    <?= $this->render("../staff/_select-table-form", [
        "form"              => $form,
        "model"             => $model,
        "staffSearch"       => $staffSearch,
        "staffDataProvider" => $staffDataProvider,
        "exclude"           => ["team"],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? "Create" : "Update",
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>