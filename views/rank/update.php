<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rank */

$this->title = 'Update Rank';
$this->params['breadcrumbs'][] = ['label' => 'Ranks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rank-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>