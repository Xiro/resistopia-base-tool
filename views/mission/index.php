<?php

use app\helpers\ValMap;
use app\models\MissionStatus;
use app\models\MissionType;
use dosamigos\datetimepicker\DateTimePicker;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\page\IndexSearchAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $search \app\models\search\MissionSearch */

IndexSearchAsset::register($this);

$this->title = 'Missions';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mission-index">
    <div class="container">


        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> Create Mission",
                ["create"],
                ["class" => "btn btn-primary"]
            ); ?>
            </span>
        </h1>

        <div class="">

            <?= $this->render("_mission-table", [
                "search"        => $search,
                "missionModels" => $dataProvider->getModels(),
            ]) ?>

        </div>
    </div>
</div>