<?php

use mate\yii\assets\TableSearchAsset;
use mate\yii\widgets\Glyphicon;
use app\assets\page\StaffAssignFormAsset;

/* @var $this yii\web\View */
/* @var $selectableDataProvider yii\data\ActiveDataProvider */
/* @var $selectedDataProvider yii\data\ActiveDataProvider */
/* @var $model \yii\db\ActiveRecord */
/* @var $exclude array */

$exclude = !isset($exclude) ? array() : $exclude;
$model = isset($model) ? $model : new \app\models\Staff();
$modelName = (new ReflectionClass($model))->getShortName();

TableSearchAsset::register($this);
StaffAssignFormAsset::register($this);
?>
<div id="staff-search-form"
     class="animated-label table-search-form"
     data-target-table="#staff-search-table">
</div>

<div class="row table-form">
    <div class="col-sm-6">
        <table class="table table-bordered staff-table table-form-selectable" id="staff-search-table">
            <thead>
                <?php if (!in_array("rpn", $exclude)): ?>
                    <th class="rpn"><?= 'RPN' ?></th>
                <?php endif; ?>
                <?php if (!in_array("name", $exclude)): ?>
                    <th class="name"><?= 'Name' ?></th>
                <?php endif; ?>
                <?php if (!in_array("team", $exclude)): ?>
                    <th class="team"><?= 'Team' ?></th>
                <?php endif; ?>
                <th class="actions text-right" style="padding: 8px!important">
                    <?= Glyphicon::arrow_right(["class" => "list-btn add-all-rows"]) ?>
                </th>
            </thead>
            <?= $this->render("_table-assign-body", [
                "dataProvider"           => $selectableDataProvider,
                "modelName"              => $modelName,
                "exclude"                => $exclude,
            ]); ?>
        </table>
    </div>
    <div class="col-sm-6">

        <table class="table table-bordered staff-table table-form-selected">
            <thead>
            <tr>
                <?php if (!in_array("rpn", $exclude)): ?>
                    <th class="rpn"><?= 'RPN' ?></th>
                <?php endif; ?>
                <?php if (!in_array("name", $exclude)): ?>
                    <th class="name"><?= 'Name' ?></th>
                <?php endif; ?>
                <?php if (!in_array("team", $exclude)): ?>
                    <th class="team"><?= 'Team' ?></th>
                <?php endif; ?>
                <th class="actions text-right" style="padding: 8px!important">
                    <?= Glyphicon::arrow_left(["class" => "assigned-btn add-all-rows"]) ?>
                </th>
            </tr>
            </thead>
            <?php
            $selectedDataProvider->setPagination(false);
            ?>
            <?= $this->render("_table-assign-body", [
                "dataProvider"           => $selectedDataProvider,
                "modelName"              => $modelName,
                "exclude"                => $exclude,
                "checked"                => true,
            ]); ?>
        </table>
    </div>
</div>
