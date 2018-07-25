<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MedicineCheckupForm */

$this->title = 'A38 bearbeiten';
$this->params['breadcrumbs'][] = ['label' => 'Medicine Checkups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medicine-checkup-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>