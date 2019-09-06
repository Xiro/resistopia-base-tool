<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;
use mate\yii\widgets\SelectData;
use app\models\MissionStatus;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MissionForm */

$this->title = 'Debrief Mission';
$this->params['breadcrumbs'][] = ['label' => 'Missions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Debrief';
?>
<div class="mission-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="mission-form">
            <?php $form = ActiveForm::begin([
                "options"     => ["class" => "animated-label"],
                "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
            ]); ?>

            <?= $form->field($model, 'finished')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>

            <?= $form->field($model, 'debrief_comment')->textarea(['rows' => 10]) ?>

            <?= $form->field($model, 'note')->textarea(['rows' => 10]) ?>

            <div class="form-group">
                <?php $statusIds = SelectData::fromModel(MissionStatus::class, 'name', 'id') ?>
                <?= Html::submitButton(
                    'Save',
                    [
                        "name"  => "MissionForm[mission_status_id]",
                        "value" => $statusIds['completed'],
                        "class" => "btn btn-success"
                    ]
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>