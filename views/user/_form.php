<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use yii\helpers\ArrayHelper;

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
        <?php if ($model->isNewRecord && !$model->approved): ?>
            <div class="col-sm-12">
                <?= $form->field($model, 'rpn', [
                    'labelOptions' => ['class' => ($model->sid ? 'move' : '')]
                ])->widget(Select2::class, [
                    'showToggleAll' => false,
                    'data'          => ArrayHelper::map(
                        \app\models\Staff::find()
                            ->leftJoin('user', 'user.rpn = staff.rpn')
                            ->where(['user.rpn' => null])
                            ->all(),
                        'rpn',
                        'nameWithRpn'
                    ),
                    'options'       => [
                        'placeholder' => '',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label('Rpn') ?>
            </div>
        <?php else: ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'rpn', [
                    'labelOptions' => ['class' => ($model->sid ? 'move' : '')]
                ])->widget(Select2::class, [
                    'showToggleAll' => false,
                    'data'          => SelectData::fromModel(
                        \app\models\Staff::class,
                        "rpn",
                        "nameWithRpn",
                        true
                    ),
                    'options'       => [
                        'placeholder' => '',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label('Rpn') ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'approved', [
                    'labelOptions' => ['class' => 'move']
                ])->widget(Select2::class, [
                    'showToggleAll' => false,
                    'data'          => [1 => 'Yes', 0 => 'No'],
                ])->label('Approved') ?>
            </div>
        <?php endif; ?>
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
            $model->isNewRecord ? $model->approved ? 'Create' : 'Request Account' : 'Update',
            ["class" => "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>