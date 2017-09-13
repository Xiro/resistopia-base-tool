<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel yii\data\ActiveDataProvider */

$this->title = 'Mission Calls';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mission-call-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> Add Mission Call",
                ["create"],
                ["class" => "btn btn-primary ajax-dialog"]
            ); ?>
            </span>
        </h1>

        <div class="">

            <table class="table table-bordered" id="mission-call-table">
                <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        RP
                    </th>
                    <th>
                        FP
                    </th>
                    <th>
                        Zone
                    </th>
                    <th>
                        Start
                    </th>
                    <th>
                        End
                    </th>
                    <th>
                        F
                    </th>
                    <th>
                        R
                    </th>
                    <th>
                        M
                    </th>
                    <th>
                        T
                    </th>
                    <th>
                        S
                    </th>
                    <th>
                        G
                    </th>
                    <th>
                        VIP
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?= $this->render("_mission-call-table-body", [
                    "missionCallModels" => $dataProvider->getModels()
                ]) ?>
                </tbody>
            </table>

        </div>
    </div>
</div>