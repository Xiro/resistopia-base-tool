<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\StaffFileMemo */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="staff-file-memo-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'access_bit_id', [
                'labelOptions' => ['class' => ($model->access_bit_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ArrayHelper::map(
                    app\models\AccessBit::find()->where(['like', 'key', 'security-level/%', false])->all(),
                    'bit_pos',
                    'name'
                ),
                'options'       => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Required Security Level') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'file_memo')->textarea(['rows' => 12]) ?>
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