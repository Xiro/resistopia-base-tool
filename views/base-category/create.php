<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BaseCategory */

$this->title = 'Create Base Category';
$this->params['breadcrumbs'][] = ['label' => 'Base Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-category-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>