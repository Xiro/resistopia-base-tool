<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BaseCategory */

$this->title = 'Update Base Category';
$this->params['breadcrumbs'][] = ['label' => 'Base Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="base-category-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>