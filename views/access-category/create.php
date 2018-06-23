<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccessCategory */

$this->title = 'Create Access Category';
$this->params['breadcrumbs'][] = ['label' => 'Access Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-category-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>