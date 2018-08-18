<?php

use app\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\Staff */

$this->title = 'Character Registration';
?>
<div class="pre-event-select-character">

    <div class="fill-page text-center">
        <div class="container">
            <h1><?= $this->title ?></h1>

            <?php $form = ActiveForm::begin([
                "options"     => ["class" => "animated-label"],
                "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
            ]); ?>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-2 col-md-3 col-md-offset-3">
                    <?= $form->field($model, 'rpn')->textInput([
                        'maxlength' => true,
                        'class'     => 'form-control mask-rpn'
                    ])->label('Enter RPN') ?>
                </div>
                <div class="col-sm-4 col-md-3">
                    <?= Html::submitButton(
                        "Update your character",
                        ["class" => "btn btn-primary"]
                    ) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <hr>

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <?= Html::a(
                        Html::button(
                            'Or create a new character',
                            ['class' => 'btn btn-primary']
                        ),
                        ['character-registration/create']
                    ); ?>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
