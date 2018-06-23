<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SpecialFunction */

$this->title = 'Update Special Function';
$this->params['breadcrumbs'][] = ['label' => 'Special Functions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="special-function-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>