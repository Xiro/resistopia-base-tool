<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ResistanceCell */

$this->title = 'Create Resistance Cell';
$this->params['breadcrumbs'][] = ['label' => 'Resistance Cells', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resistance-cell-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>