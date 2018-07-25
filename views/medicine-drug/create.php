<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MedicineDrug */

$this->title = 'Create Medicine Drug';
$this->params['breadcrumbs'][] = ['label' => 'Medicine Drugs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicine-drug-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>