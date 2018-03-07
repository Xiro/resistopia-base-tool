<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\StaffSearch */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="staff-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> Add Staff Member',
                ["create"],
                ["class" => "btn btn-primary"]
            ); ?>
            </span>
        </h1>

        <div class="">
            <?= $this->render("_table", [
                "searchModel" => $searchModel,
                "models"      => $dataProvider->getModels(),
            ]) ?>
        </div>
    </div>
</div>