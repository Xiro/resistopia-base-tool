<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StaffBackground */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="staff-background-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'story_before')->textarea(['rows' => 12]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'story_during')->textarea(['rows' => 12]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'story_after')->textarea(['rows' => 12]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'career')->textarea(['rows' => 12]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'characteristics')->textarea(['rows' => 12]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'personality')->textarea(['rows' => 12]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'awards')->textarea(['rows' => 12]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ["class" => $model->isNewRecord ? "btn btn-primary" : "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>