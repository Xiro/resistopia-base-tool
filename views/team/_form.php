<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
/* @var $model app\models\Team */
/* @var $form yii\bootstrap\ActiveForm */
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
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