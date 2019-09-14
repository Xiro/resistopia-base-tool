<?php

use app\models\Team;
use mate\yii\widgets\SelectData;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
/* @var $model app\models\RadioMessage */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="radio-message-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4">
            <?= $form->field($model, 'callsign', [
                'labelOptions' => ['class' => ($model->callsign ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => \yii\helpers\ArrayHelper::map(
                    \app\models\RadioMessage::find()
                        ->orderBy('created DESC')
                        ->groupBy(['callsign'])
                        ->all(),
                    'callsign',
                    'callsign'
                ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags'       => true,
                ],
            ])->label('Callsign') ?>
        </div>
        <div class="col-lg-10 col-md-9 col-sm-8">
            <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>
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