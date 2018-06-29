<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mate\yii\widgets\ValMap;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessMaskForm */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="access-mask-form">

    <?php $form = ActiveForm::begin([
        "options"     => ["class" => "animated-label"],
        "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <?php if (!$model->protected || $model->isNewRecord): ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'protected', [
                    'labelOptions' => ['class' => 'move']
                ])->widget(Select2::class, [
                    'showToggleAll' => false,
                    'data'          => [1 => 'Yes', 0 => 'No']
                ]) ?>
            </div>
        <?php endif; ?>
    </div>

    <?= $this->render('../access-right/_checkboxes', [
        'form'      => $form,
        'model'     => $model,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>