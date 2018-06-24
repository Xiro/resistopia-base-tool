<?php

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;

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

    <h4>Personal Information</h4>

    <?php
    $personalInfo = [];
    $personalInfo["RPN"] = $model->rpn;
    $personalInfo["Height"] = $model->height ? $model->height . " cm" : "n/a";
    $personalInfo["Gender"] = $model->gender ? $model->gender : "n/a";

    $personalInfo["name"] = $model->getName();
    $personalInfo["Eye Color"] = $model->eye_color_id ? $model->eyeColor->name : "n/a";
    $personalInfo["Profession"] = $model->profession ? $model->profession : "n/a";

    $personalInfo["Date of Birth"] = $model->date_of_birth ? date("d.m.Y", strtotime($model->date_of_birth)) : "n/a";
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

    <?php if ($model->staffBackground): ?>
        <br><br>
        <?= $this->render('../staff-background/_details', [
            'model' => $model->staffBackground
        ]) ?>
    <?php endif; ?>

</div>
