<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MediFoamDistribution */

$this->title = 'Update Medi Foam Distribution';
$this->params['breadcrumbs'][] = ['label' => 'Medi Foam Distributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medi-foam-distribution-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>