<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\widgets\SelectData;

/* @var $this yii\web\View */
/* @var $model app\models\forms\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'rpn', [
                'labelOptions' => ['class' => ($model->rpn ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(
                         app\models\Staff::class,
                         'rpn', 
                         'rpn'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Rpn') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(
                $model->isNewRecord ? "Password" : "New Password"
            ) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true])->label(
                $model->isNewRecord ? "Repeat Password" : "Repeat New Password"
            ) ?>
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