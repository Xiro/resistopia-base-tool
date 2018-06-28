<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\MissionSearch */
/* @var $searchUrl string */
/* @var $title string */

$this->title = $title ? $title : 'Missions';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mission-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> " . 'Create Mission',
                ["create"],
                ["class" => "btn btn-default"]
            ); ?>
            </span>
        </h1>

        <?php if($dataProvider->query->count()): ?>
        <div class="">
            <?= $this->render("_table", [
                "dataProvider" => $dataProvider,
                "searchModel"  => $searchModel,
                "searchUrl"    => $searchUrl,
            ]) ?>
        </div>
        <?php else: ?>
            <div class="no-tables text-center">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <h2>No Missions to show</h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>