<?php

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;
use yii\data\ActiveDataProvider;
use app\components\Access;

/* @var $this yii\web\View */
/* @var $model app\models\Staff */

$this->title = $model->nameWithRpn;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-view container-fluid">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?= Html::a(
            'Update',
            ['update', 'id' => $model->rpn],
            ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a(
            'Delete',
            ['confirm-delete', 'id' => $model->rpn],
            ['class' => 'btn btn-danger ajax-dialog', "data-size" => "sm"]
        ) ?>
        </span>
    </h1>

    <?php if ($model->isBlocked): ?>
        <div class="text-center row">
            <div class="alert alert-danger col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
                <?= Glyphicon::alert() ?>
                &nbsp;BLOCKED FROM MISSIONS&nbsp;
                <?= Glyphicon::alert() ?>
            </div>
        </div>
    <?php endif; ?>

    <h4>Personal Information</h4>

    <?php
    $personalInfo = [];
    $personalInfo["name"] = $model->getName();
    $personalInfo["RPN"] = $model->rpn;

    $personalInfo["Gender"] = $model->gender ? $model->gender : "n/a";
    $personalInfo["Height"] = $model->height ? $model->height . " cm" : "n/a";

    $personalInfo["Blood Type"] = $model->blood_type_id ? $model->bloodType->name : "n/a";
    $personalInfo["Eye Color"] = $model->eye_color_id ? $model->eyeColor->name : "n/a";

    $personalInfo["Date of Birth"] = $model->date_of_birth ? date("d.m.Y", strtotime($model->date_of_birth)) : "n/a";
    $personalInfo["Profession"] = $model->profession ? $model->profession : "n/a";
    ?>
    <div class="model-details row personal-info">
        <?php foreach ($personalInfo as $label => $value): ?>
            <div class="col-md-6">
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

    <h4>Affiliations</h4>

    <?php
    $affiliations = [];
    $affiliations["Team"] = $model->team_id ? '<span style="white-space: nowrap">' . $model->team->name . " " . Html::a(
            Glyphicon::eye_open(),
            ["team/view", "id" => $model->team_id],
            ["class" => "ajax-dialog", "data-size" => "lg"]
        ) . '</span>' : "None";
    $affiliations["Category"] = $model->base_category_id ? $model->baseCategory->name : "n/a";
    $affiliations["Company"] = $model->company_id ? $model->company->name : "n/a";

    $affiliations["Rank"] = $model->rank_id ? $model->rank->name : "n/a";
    $affiliations["Speciality"] = $model->special_function_id ? $model->specialFunction->name : "n/a";
    $affiliations["Citizenship"] = $model->citizenship_id ? $model->citizenship->name : "n/a";

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
    $systemInfo["Call Sign"] = $model->callsign ? $model->callsign : "n/a";
    $systemInfo["Alive"] = $model->status_alive ? "Yes" : "No";
    $systemInfo["Created"] = date("d.m.Y H:i", strtotime($model->created));

    $systemInfo["In Base"] = $model->status_in_base ? "Yes" : "No";
    $systemInfo["Is IT"] = $model->status_it ? "Yes" : "No";
    $systemInfo["Last Update"] = date("d.m.Y H:i", strtotime($model->updated));

    $systemInfo["In BE13"] = $model->status_be13 ? "Yes" : "No";

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

    <?php if ($model->getMissionBlocks()->count() > 0 && Access::to('mission-block/view')): ?>
        <div class="model-details-section">
            <h3>
                Mission Blocks
                <?php if ($model->isBlocked): ?>
                <span class="heading-btn-group pull-right">
                    <?= Html::a(
                            'Lift Block',
                            ['mission-block/lift', 'id' => $model->rpn],
                            ['class' => 'btn btn-default']
                    ) ?>
                </span>
                <?php endif; ?>
            </h3>

            <?= $this->render('../mission-block/_table', [
                'dataProvider' => new ActiveDataProvider([
                    'query'      => $model->getMissionBlocks()->orderBy(['created' => 'ASC']),
                    'pagination' => false,
                ]),
                'exclude'      => ['blocked_staff_member'],
            ]) ?>
        </div>
    <?php endif; ?>

    <?php if ($model->getStaffFileMemos()->count() > 0 && Access::to('staff-file-memo/view')): ?>
        <div class="model-details-section">
            <h4>File Memos</h4>

            <?= $this->render('../staff-file-memo/_table', [
                'dataProvider' => new ActiveDataProvider([
                    'query'      => $model->getStaffFileMemos(),
                    'pagination' => false,
                ]),
                'exclude'      => ['staff_name'],
            ]) ?>
        </div>
    <?php endif; ?>

    <?php if ($model->staffBackground): ?>
        <div class="model-details-section">
            <?= $this->render('../staff-background/_details', [
                'model' => $model->staffBackground
            ]) ?>
        </div>
    <?php endif; ?>

</div>
