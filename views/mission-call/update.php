<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MissionCall */

$this->title = 'Update Mission Call';
$this->params['breadcrumbs'][] = ['label' => 'Mission Calls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mission-call-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>