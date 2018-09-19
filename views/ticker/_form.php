<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
/* @var $model app\models\Ticker */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="ticker-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'active', [
                'labelOptions' => ['class' => "move"]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => [
                    0 => 'Inactive',
                    1 => 'Active'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'order')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ["class" => "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>