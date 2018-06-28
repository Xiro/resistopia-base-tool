<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;

/* @var $this yii\web\View */
/* @var $model app\models\AccessSecurityArea */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="access-security-area-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'access_bit_pos', [
                'labelOptions' => ['class' => ($model->access_bit_pos ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(
                         app\models\AccessBit::class,
                         'bit_pos', 
                         'name'
                     ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Access Bit Pos') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ["class" => "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>