<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\forms\MedicineTreatmentForm */

$this->title = 'Behandlungsprotokoll anlegen';
$this->params['breadcrumbs'][] = ['label' => 'Medicine Treatments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicine-treatment-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>