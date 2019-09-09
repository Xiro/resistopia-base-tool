<?php

use app\helpers\Html;
use kartik\select2\Select2;
use mate\yii\widgets\SelectData;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\forms\UserForm */

$this->title = 'Forgot Password';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-request row">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-4 col-sm-10 col-sm-offset-1 content border-light">

        <h2><?= Html::encode($this->title) ?></h2>

        <div class="user-form">

            <?php $form = ActiveForm::begin([
                "options"     => ["class" => "animated-label"],
                "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
            ]); ?>

            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'sid', [
                        'labelOptions' => ['class' => ($model->sid ? 'move' : '')]
                    ])->widget(Select2::class, [
                        'showToggleAll' => false,
                        'data'          => ArrayHelper::map(
                            \app\models\Staff::find()
                                ->leftJoin('user', 'user.sid = staff.sid')
                                ->where(['not', ['user.sid' => null]])
                                ->all(),
                            'sid',
                            'nameWithSid'
                        ),
                        'options'       => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('SID') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(
                        "New Password"
                    ) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true])->label(
                        "Repeat New Password"
                    ) ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton(
                    'Request new password',
                    ["class" => "btn btn-primary"]
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>