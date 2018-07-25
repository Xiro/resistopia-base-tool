<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MedicineDrug */

$this->title = 'Update Medicine Drug';
$this->params['breadcrumbs'][] = ['label' => 'Medicine Drugs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medicine-drug-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>