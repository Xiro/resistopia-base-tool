<?php

use app\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MissionForm */

$this->title = 'Update Mission';
$this->params['breadcrumbs'][] = ['label' => 'Missions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mission-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>


        <div class="mission-form">

            <?php $form = ActiveForm::begin([
                "options"     => ["class" => "animated-label"],
                "fieldConfig" => ["template" => "{input}\n{label}\n{hint}\n{error}"],
            ]); ?>

            <h5>Slots</h5>

            <?php
            $slots = [];
            $slots["Medics"] = $model->slots_medic ? $model->slots_medic : 0;
            $slots["Technicians"] = $model->slots_tech ? $model->slots_medic : 0;
            $slots["Guards"] = $model->slots_guard ? $model->slots_guard : 0;

            $slots["Radio Ops"] = $model->slots_radio ? $model->slots_radio : 0;
            $slots["Res"] = $model->slots_res ? $model->slots_res : 0;
            $slots["VIPs"] = $model->slots_vip ? $model->slots_vip : 0;

            $slots["Total"] = $model->slots_total ? $model->slots_total : 0;
            ?>
            <div class="model-details row personal-info">
                <?php foreach ($slots as $label => $value): ?>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-6 detail-label">
                                <?= $label ?>
                            </div>
                            <div class="col-sm-6 detail-value">
                                <?= $value ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <h4>Staff</h4>

            <?= $this->render('_staff-form', [
                'form'  => $form,
                'model' => $model,
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton(
                    $model->isNewRecord ? 'Create' : 'Update',
                    ["class" => $model->isNewRecord ? "btn btn-success" : "btn btn-primary"]
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>