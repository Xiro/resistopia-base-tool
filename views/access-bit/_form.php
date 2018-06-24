<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessBitForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="access-bit-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
        "id"          => 'access-bit-form'
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'access_category_id', [
                'labelOptions' => ['class' => ($model->access_category_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(app\models\AccessCategory::class),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ])->label('Access Category') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            [
                "class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary",
                "name"  => "submit",
                "value" => "submit",
                'id'    => 'submit'
            ]
        ) ?>
        <?php if ($model->isNewRecord): ?>
            <?= Html::submitButton(
                'Create and New',
                [
                    "class" => "btn btn-success",
                    "name"  => "submit",
                    "value" => "continue",
                    'id'    => 'submit-and-new'
                ]
            ) ?>
        <?php endif; ?>
    </div>

    <?= $form->field($model, 'order')->hiddenInput()->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>