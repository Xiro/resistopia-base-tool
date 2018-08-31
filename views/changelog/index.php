<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\ChangelogSearch */

$this->title = 'Changelogs';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="changelog-index">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>

            <span class="heading-btn-group pull-right">
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