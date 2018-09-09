<?php

use app\helpers\Html;
use yii\data\ActiveDataProvider;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $tableQueries \yii\db\ActiveQuery[] */

$this->title = 'Mission Screen';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if (!Yii::$app->request->isAjax): ?>

<style>
    .content-center {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        position: fixed;
    }

    .background {
        z-index: -100;
        opacity: 0.2;
        width: 100%;
        left: 0;
    }

    .mission-screen {
        left: 5%;
        width: 90%;
    }
    .mission-screen div {
        width: 100%;
    }

    .background-content {
    }

    .background img {
        transform: scale(1.5)!important;
    }
</style>

<div class="background content-center">
    <div class="background-content">
        <?= $this->render('../layouts/_icon-rotation') ?>
    </div>
</div>

<div class="mission-screen content-center mission-table">
    <div class="">

        <?= Glyphicon::refresh(['class' => 'btn-auto-reload active hidden']) ?>
        <?php endif; ?>

        <div class="reload-target">
            <br>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Operation</th>
                    <th>Zone</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Medic</th>
                    <th>Radio</th>
                    <th>Tech</th>
                    <th>Res</th>
                    <th>Guard</th>
                    <th>VIP</th>
                    <th>Status</th>
                    <th>LST</th>
                    <th>ETE</th>
                    <th>ATF</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tableQueries as $i => $query): ?>
                    <?php if ($query->count() == 0) continue; ?>
                    <?php if ($i != 0): ?>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                    <?php endif; ?>
                    <?php
                    /** @var \app\models\Mission[] $models */
                    $models = $query->all();
                    ?>
                    <?php foreach ($models as $model): ?>
                        <tr>
                            <td><?= $model->name ?></td>
                            <td><?= $model->operation_id ? $model->operation->name : 'n/a' ?></td>
                            <td><?= $model->zone ?></td>
                            <td><?= $model->mission_type_id ? $model->missionType->name : 'n/a' ?></td>
                            <td><?= $model->slots_total ?></td>
                            <td><?= $model->slots_medic ?></td>
                            <td><?= $model->slots_radio ?></td>
                            <td><?= $model->slots_tech ?></td>
                            <td><?= $model->slots_res ?></td>
                            <td><?= $model->slots_guard ?></td>
                            <td><?= $model->slots_vip ?></td>
                            <td><?= $model->mission_status_id ? $model->missionStatus->name : 'n/a' ?></td>
                            <td class="time_lst"><?= $model->time_lst ? date('H:i d.m.Y', strtotime($model->time_lst)) : 'n/a' ?></td>
                            <td class="time_ete"><?= $model->time_ete ? date('H:i d.m.Y', strtotime($model->time_ete)) : 'n/a' ?></td>
                            <td class="time_atf"><?= $model->time_atf ? date('H:i', strtotime($model->time_atf)) : 'n/a' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (!Yii::$app->request->isAjax): ?>
        <div class="legend" style="font-size: 13px">
            <div style="width: 50%; display: inline-block; float:left;">
                <b>Status planing:</b> Mission is planed in the CIC, a mission lead is needed soon<br>
                <b>Status openLeadercall:</b> A mission leader is needed to collect the mission team<br>
                <b>Status openCrewcall:</b> The mission leader registers team members<br>
            </div>
            <div style="width: 50%; display: inline-block">
                <b>LST - Limit of Start Time:</b> Latest time the mission team should leave the gate<br>
                <b>ETE - Estimated Time of Execution:</b> Time the mission is executed in the field<br>
                <b>ATF - Accepted Time Favor:</b> Longest time period the mission should take<br>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
