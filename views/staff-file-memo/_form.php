<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use mate\yii\widgets\SelectData;

/* @var $this yii\web\View */
/* @var $model app\models\StaffFileMemo */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="staff-file-memo-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <?php if($model->isNewRecord && !$model->sid): ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'rpn', [
                'labelOptions' => ['class' => ($model->sid ? 'move' : '')]
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
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'access_right_id', [
                'labelOptions' => ['class' => ($model->access_right_id ? 'move' : '')]
            ])->widget(Select2::class, [
                'showToggleAll' => false,
                'data'          => ArrayHelper::map(
                    app\models\AccessRight::find()->where(['like', 'key', 'security-level/%', false])->all(),
                    'id',
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
            ["class" => "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>