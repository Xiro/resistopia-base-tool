<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MissionBlock */

$this->title = 'Update Mission Block';
$this->params['breadcrumbs'][] = ['label' => 'Mission Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mission-block-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>