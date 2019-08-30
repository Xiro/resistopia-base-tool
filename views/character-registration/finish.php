<?php

use app\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\Staff */

$this->title = 'Your RPN: ' . $model->sid;
?>
<div class="pre-event-select-character">

    <div class="fill-page text-center">
        <div class="container">
            <h1><?= $this->title ?></h1>

            <p class="text-large">
                <b>Important!</b><br> Remember your RPN <?= $model->sid ?>, you will need it during the event or if you want to make more changes before the event.<br>
                If you want to change any information during the event, visit the CIC.
            </p>

            <hr>

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <?= Html::a(
                        Html::button(
                            'Go back, I forgot something',
                            ['class' => 'btn btn-default']
                        ),
                        ['character-registration/update', 'id' => $model->sid]
                    ); ?>
                </div>
            </div>
        </div>
    </div>

</div>
