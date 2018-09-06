<?php

use app\helpers\Html;
use yii\widgets\DetailView;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model app\models\MissionBlock */

$this->title = "Block of " . $model->blocked_staff_member_rpn;
$this->params['breadcrumbs'][] = ['label' => 'Mission Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mission-block-view container-fluid">

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

    <?php
    $info = [];
    $info["Blocked Staff"] = Html::staffLabel($model->blockedStaffMember);
    $info["Blocked By"] = Html::staffLabel($model->blockedBy);
    $info["Unblock Time"] = $model->unblock_time ? date("d.m.Y H:i", strtotime($model->unblock_time)) : "n/a";
    $info["Reason"] = $model->reason ? $model->reason : "n/a";
    $info["Created"] = $model->created ? date("d.m.Y H:i", strtotime($model->created)) : "n/a";
    ?>
    <div class="model-details row">
        <?php foreach ($info as $label => $value): ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-3 detail-label">
                        <?= $label ?>
                    </div>
                    <div class="col-sm-9 detail-value">
                        <?= $value ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>