<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\forms\LoginForm */

use app\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 content border-light">

            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'id'          => 'login-form',
                "options"     => ["class" => "animated-label borderless"],
                'fieldConfig' => ['template' => "{input}\n{label}\n{hint}\n{error}"],
            ]); ?>

            <?= $form->field($model, 'sid')->textInput([
                'maxlength'    => true,
                'autocomplete' => 'off',
                'class'        => 'form-control mask-sid'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'autocomplete' => 'off'
            ]) ?>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <?= Html::a(
                            Html::button(
                                'Request Account',
                                ['class' => 'btn btn-default', 'name' => 'login-button', 'style' => 'width: 100%']
                            ),
                            ['user/request']
                        ); ?>
                    </div>
                    <div class="col-sm-6">
                        <?= Html::a(
                            Html::button(
                                'Forgot Password',
                                ['class' => 'btn btn-default', 'name' => 'login-button', 'style' => 'width: 100%']
                            ),
                            ['user/forgot-password']
                        ); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <?= Html::submitButton(
                            '&nbsp; <span class="glyphicon glyphicon-log-in"></span> &nbsp; Login &nbsp;',
                            ['class' => 'btn btn-primary', 'name' => 'login-button', 'style' => 'width: 100%']
                        ) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>