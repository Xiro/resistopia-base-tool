<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\MedicineTreatmentForm */

$this->title = 'Behandlungsprotokoll bearbeiten';
$this->params['breadcrumbs'][] = ['label' => 'Medicine Treatments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medicine-treatment-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>