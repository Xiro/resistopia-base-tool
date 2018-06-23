<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\UserSearch */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> " . 'Create User',
                ["create"],
                ["class" => "btn btn-success"]
            ); ?>
            </span>
        </h1>

        <div class="">
            <?= $this->render("_table", [
                "dataProvider" => $dataProvider,
                "searchModel"  => $searchModel,
            ]) ?>
        </div>
    </div>
</div>