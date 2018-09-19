<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ticker */

$this->title = 'Update Ticker';
$this->params['breadcrumbs'][] = ['label' => 'Tickers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ticker-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>