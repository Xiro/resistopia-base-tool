<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MediFoamDistribution */

$this->title = 'Create Medi Foam Distribution';
$this->params['breadcrumbs'][] = ['label' => 'Medi Foam Distributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medi-foam-distribution-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>