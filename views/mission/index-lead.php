<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $models \app\models\Mission[] */

$this->title = 'Missions lead by you';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mission-index">
    <div class="container">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>

        <?php foreach ($models as $model): ?>

            <h2><?= $model->name ?></h2>

            <h5>Information</h5>

            <?php
            $info = [];
            $info["Type"] = $model->mission_type_id ? $model->missionType->name : "n/a";

            $info["Operation"] = $model->operation_id ? $model->operation->name : "none";
            $info["Status"] = $model->mission_status_id ? $model->missionStatus->name : "n/a";

            $info["Zone"] = $model->zone;
            ?>
            <div class="model-details row information">
                <?php foreach ($info as $label => $value): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="row">
                            <div class="col-sm-6 col-md-5 col-lg-4 detail-label">
                                <?= $label ?>
                            </div>
                            <div class="col-sm-6 col-md-7 col-lg-8 detail-value">
                                <?= $value ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <h5>Schedule</h5>

            <?php
            $schedule = [];
            $schedule["Limit of Start Time"] = $model->time_lst ? date('d.m.Y H:i', strtotime($model->time_lst)) : 'n/a';
            $schedule["Time of Execution"] = $model->time_ete ? date('d.m.Y H:i', strtotime($model->time_ete)) : 'n/a';

            $schedule["Accepted Time Favor"] = $model->time_atf ? date('H:i', strtotime($model->time_atf)) : 'n/a';
            $schedule["Finished"] = $model->finished ? date('d.m.Y H:i', strtotime($model->finished)) : 'n/a';
            ?>
            <div class="model-details row personal-info">
                <?php foreach ($schedule as $label => $value): ?>
                    <div class="col-sm-6 col-md-6 col-lg-4">
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
                <h5>Description</h5>
                <p>
                    <?= nl2br($model->description) ?>
                </p>
            <?php endif; ?>

        <br>
        <p>
        <?= Html::a(
                'Update Crew',
                ['mission/update-crew', 'id' => $model->id],
                ['class' => 'btn btn-default']
            ); ?>
        </p>

        <?php endforeach; ?>

    </div>
</div>