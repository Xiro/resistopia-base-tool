<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $search \app\models\search\TeamSearch */

$this->title = 'Teams';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="team-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> Add Team",
                ["create"],
                ["class" => "btn btn-primary"]
            ); ?>
            </span>
        </h1>

        <div class="cropped-width-md">

            <?= $this->render("_team-table", [
                "search"     => $search,
                "teamModels" => $dataProvider->getModels(),
            ]) ?>

        </div>
    </div>
</div>