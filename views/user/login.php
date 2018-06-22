<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login row">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="col-md-4 col-md-offset-4 content border-light">

        <h2><?= Html::encode($this->title) ?></h2>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            "options" => ["class" => "animated-label borderless"],
            'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}"],
        ]); ?>

        <?= $form->field($model, 'rpn')->textInput(['autocomplete' => 'off']) ?>

        <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off']) ?>

        <div class="form-group text-right">
            <?= Html::submitButton(
                '&nbsp; <span class="glyphicon glyphicon-log-in"></span> &nbsp; Login &nbsp;',
                ['class' => 'btn btn-primary', 'name' => 'login-button']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>