<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
/* @var $model app\models\MissionBlock */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="mission-block-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'unblock_time', [
                'options' => ['class' => "form-group date-picker"],
                'labelOptions' => ['class' => ($model->unblock_time ? "move" : "")]
            ])->widget(\dosamigos\datetimepicker\DateTimePicker::className(), [
                'size' => 'sm',
                'template' => '{input}',
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'clientOptions' => [
                    'type' => 'TYPE_BUTTON',
                    'startView' => 1,
                    'minView' => 0,
                    'maxView' => 1,
                    'autoclose' => true,
                    'linkFormat' => 'HH:ii P', // if inline = true
                    // 'format' => 'HH:ii P', // if inline = false
                ]
            ])->label('Unblock Time (blank for unlimited block)') ;?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Block Staff' : 'Update',
            ["class" => "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>