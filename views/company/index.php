<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\CompanySearch */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="company-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
            <?= Html::a(
                "<span class=\"glyphicon glyphicon-plus\"></span> " . 'Create Company',
                ["create"],
                ["class" => "btn btn-default"]
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