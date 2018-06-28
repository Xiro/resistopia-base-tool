<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MissionBlock */

$this->title = 'Create Mission Block';
$this->params['breadcrumbs'][] = ['label' => 'Mission Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mission-block-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>