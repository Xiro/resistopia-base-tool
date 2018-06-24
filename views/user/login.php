<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\forms\LoginForm */

use app\helpers\Html;
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
    <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 content border-light">

        <h2><?= Html::encode($this->title) ?></h2>

        <?php $form = ActiveForm::begin([
            'id'          => 'login-form',
            "options"     => ["class" => "animated-label borderless"],
            'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}"],
        ]); ?>

        <?= $form->field($model, 'rpn')->textInput(['autocomplete' => 'off']) ?>

        <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off']) ?>

        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <?= Html::a(
                        Html::button(
                            'Request Account',
                            ['class' => 'btn btn-primary', 'name' => 'login-button']
                        ),
                        ['user/request']
                    ); ?>
                </div>
                <div class="col-sm-6 text-right">
                    <?= Html::submitButton(
                        '&nbsp; <span class="glyphicon glyphicon-log-in"></span> &nbsp; Login &nbsp;',
                        ['class' => 'btn btn-primary', 'name' => 'login-button']
                    ) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>