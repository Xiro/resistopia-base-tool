<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ResistanceCell */

$this->title = 'Update Resistance Cell';
$this->params['breadcrumbs'][] = ['label' => 'Resistance Cells', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="resistance-cell-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>