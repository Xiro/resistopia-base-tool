<?php

use app\helpers\Html;
use app\components\Access;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Mission */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Missions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mission-view container-fluid">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?= Html::a(
            'Update',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a(
            'Delete',
            ['confirm-delete', 'id' => $model->id],
            ['class' => 'btn btn-danger ajax-dialog', "data-size" => "sm"]
        ) ?>
        </span>
    </h1>

    <h4>Information</h4>

    <?php
    $info = [];
    $info["Name"] = $model->name;
    $info["Type"] = $model->mission_type_id ? $model->missionType->name : "n/a";

    $info["Operation"] = $model->operation_id ? $model->operation->name : "none";
    $info["Status"] = $model->mission_status_id ? $model->missionStatus->name : "n/a";

    $info["Created by"] = $model->created_by_sid ? $model->createdBy->nameWithSid : "n/a";
    $info["Zone"] = $model->zone;

    $info["Mission Lead"] = $model->mission_lead_sid ? $model->missionLead->nameWithSid : "n/a";
    $info["Callsign"] = implode(", ", $model->callsigns);

    ?>
    <div class="model-details row information">
        <?php foreach ($info as $label => $value): ?>
            <div class="col-sm-6">
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

    <h4>Schedule</h4>

    <?php
    $schedule = [];
    $schedule["Limit of Start Time"] = $model->time_lst ? date('d.m.Y H:i', strtotime($model->time_lst)) : 'n/a';
    $schedule["Time of Execution"] = $model->time_ete ? date('d.m.Y H:i', strtotime($model->time_ete)) : 'n/a';

    $schedule["Accepted Time Favor"] = $model->time_atf ? date('H:i', strtotime($model->time_atf)) : 'n/a';
    $schedule["Finished"] = $model->finished ? date('d.m.Y H:i', strtotime($model->finished)) : 'n/a';

    $schedule["Created"] = $model->created ? date('d.m.Y H:i', strtotime($model->created)) : 'n/a';
    $schedule["Last Updated"] = $model->updated ? date('d.m.Y H:i', strtotime($model->updated)) : 'n/a';
    ?>
    <div class="model-details row personal-info">
        <?php foreach ($schedule as $label => $value): ?>
            <div class="col-sm-6">
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

    <h4>Slots</h4>

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

    <?php if ($model->description): ?>
        <h4>Description</h4>
        <p>
            <?= nl2br($model->description) ?>
        </p>
    <?php endif; ?>

    <?php if ($model->debrief_comment): ?>
        <h4>Debrief Comment</h4>
        <p>
            <?= nl2br($model->debrief_comment) ?>
        </p>
    <?php endif; ?>

    <?php if ($model->note): ?>
        <h4>Note</h4>
        <p>
            <?= nl2br($model->note) ?>
        </p>
    <?php endif; ?>

    <?php if (Access::to('staff/view') && $model->getStaff()->count()): ?>

        <h4>Staff</h4>

        <?= $this->render("../staff/_table", [
            "dataProvider" => new ActiveDataProvider([
                'query'      => $model->getStaff(),
                'pagination' => false,
            ]),
            "exclude"      => [
                "action-delete",
                "status_in_base",
                'section'
            ]
        ]) ?>

    <?php endif; ?>

    <?php if ($model->getChanges()->count() > 0): ?>
        <div class="model-details-section">
            <h4>Changelog</h4>

            <?= $this->render('../changelog/_table', [
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getChanges(),
                ]),
                'exclude'      => ['object'],
            ]) ?>
        </div>
    <?php endif; ?>

</div>
