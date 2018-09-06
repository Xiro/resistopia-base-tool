<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;
use mate\yii\widgets\SelectData;

/* @var $this yii\web\View */
/* @var $model app\models\MediFoamDistribution */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="medi-foam-distribution-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'recipient_rpn', [
                'labelOptions' => ['class' => ($model->recipient_rpn ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => SelectData::fromModel(
                    app\models\Staff::class,
                    'rpn',
                    'nameWithRpn',
                    true
                ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'mk1_issued')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'mk1_returned')->textInput() ?>
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