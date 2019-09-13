<?php

use app\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ticker */

$this->title = 'Update Screen Message';
$this->params['breadcrumbs'][] = ['label' => 'Tickers', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="screen-message-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="screen-message-form">

            <?php $form = ActiveForm::begin([
                "options"     => ["class" => "animated-label"],
                "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
            ]); ?>

            <div class="row">
                <div class="col-sm-8">
                    <?= $form->field($model, 'heading')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'message')->textarea(['style' => 'height: 193px']) ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton(
                    'Update',
                    ["class" => "btn btn-primary"]
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>
    </div>
</div>