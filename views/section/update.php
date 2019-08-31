<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Section */

$this->title = 'Update section';
$this->params['breadcrumbs'][] = ['label' => 'Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="section-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>