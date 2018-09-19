<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ticker */

$this->title = 'Create Ticker';
$this->params['breadcrumbs'][] = ['label' => 'Tickers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticker-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>