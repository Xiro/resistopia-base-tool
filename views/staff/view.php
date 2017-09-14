<?php

use yii\helpers\Html;
use app\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model app\models\Staff */

$this->title = $model->getName() . " (" . $model->rpn . ")";
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-view container-fluid">

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

    <h4>Personal Information</h4>

    <?php
    $personalInfo = [];
    $personalInfo["RPN"] = $model->rpn;
    $personalInfo["Height"] = $model->height ? $model->gender . " cm" : "n/a";
    $personalInfo["Gender"] = $model->gender ? $model->gender : "n/a";

    $personalInfo["name"] = $model->getName();
    $personalInfo["Eye Color"] = $model->eye_color_id ? $model->eyeColor->name : "n/a";
    $personalInfo["Profession"] = $model->profession ? $model->profession : "n/a";
    $personalInfo["Blood Type"] = $model->blood_type_id ? $model->bloodType->name : "n/a";
    ?>
    <div class="model-details row personal-info">
        <?php foreach ($personalInfo as $label => $value): ?>
            <div class="col-md-4">
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
        <?php if ($model->comment): ?>
            <div class="col-md-12">
                <br>
                <div class="row">
                    <div class="col-sm-2 detail-label">
                        File Comment
                    </div>
                    <div class="col-sm-10 detail-value">
                        <?= nl2br($model->comment) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <h4>Affiliations</h4>

    <?php
    $affiliations = [];
    $affiliations["Team"] = $model->team_id ? '<span style="white-space: nowrap">' . $model->team->name . " " . Html::a(
            Glyphicon::eye_open(),
            ["team/view", "id" => $model->team_id],
            ["class" => "ajax-dialog", "data-size" => "lg"]
        ) . '</span>': "None";
    $affiliations["Category"] = $model->category_id ? $model->category->name : "n/a";
    $affiliations["Company"] = $model->company_id ? $model->company->name : "n/a";

    $affiliations["Rank"] = $model->rank_id ? $model->rank->name : "n/a";
    $affiliations["Speciality"] = $model->speciality_id ? $model->speciality->name : "n/a";

    ?>
    <div class="model-details row affiliations">
        <?php foreach ($affiliations as $label => $value): ?>
            <div class="col-md-4">
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

    <h4>System Information</h4>

    <?php
    $systemInfo = [];
    $systemInfo["Access"] = $model->accesses ? implode(", ", array_column($model->getAccesses()->asArray()->all(), "name")) : "n/a";
    $systemInfo["Call Sign"] = $model->call_sign ? $model->call_sign : "n/a";
    $systemInfo["Status"] = $model->staff_status_id ? $model->staffStatus->name : "n/a";

    $systemInfo["Created"] = date("d.m.Y H:i", strtotime($model->created));
    $systemInfo["Last Update"] = date("d.m.Y H:i", strtotime($model->updated));
    $systemInfo["Died"] = $model->died ? date("d.m.Y H:i", strtotime($model->died)) : "";

    $systemInfo["RP unpaid/paid"] = $model->getUnpaidRP() . "/" .$model->getPaidRP();
    $systemInfo["Is blocked"] = $model->is_blocked === "Yes" ? '<span class="btn btn-danger">BLOCKED</span>' : "No";
    $systemInfo["Is IT"] = $model->is_it;


    ?>
    <div class="model-details row affiliations">
        <?php foreach ($systemInfo as $label => $value): ?>
            <div class="col-md-4">
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


    <h4>Pending Missions</h4>

    <?php $pendingMissions = $model->getPendingMissions(); ?>
    <?php if ($pendingMissions): ?>
        <?= $this->render("../mission/_mission-table", [
            "missionModels" => $pendingMissions,
            "exclude"       => ["status", "debrief-comment", "ended", "action-delete"],
        ]); ?>
    <?php else: ?>
        <p class="text-large"><?= $model->getName() ?> is not waiting for any missions</p>
    <?php endif; ?>

    <h4>Active Missions</h4>

    <?php $activeMissions = $model->getActiveMissions(); ?>
    <?php if ($activeMissions): ?>
        <?= $this->render("../mission/_mission-table", [
            "missionModels" => $activeMissions,
            "exclude"       => ["status", "debrief-comment", "ended", "action-delete"],
        ]); ?>
    <?php else: ?>
        <p class="text-large"><?= $model->getName() ?> is currently not on a mission</p>
    <?php endif; ?>

    <h4>Past Missions</h4>

    <?php $pastMissions = $model->getPastMissions(); ?>
    <?php if ($pastMissions): ?>
        <?= $this->render("../mission/_mission-table", [
            "missionModels" => $pastMissions,
            "exclude"       => ["started", "description", "action-delete"],
        ]); ?>
    <?php else: ?>
        <p class="text-large"><?= $model->getName() ?> has not been on any mission yet</p>
    <?php endif; ?>

</div>
