<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\forms\MedicineCheckupForm */

$this->title = 'A38 anlegen';
$this->params['breadcrumbs'][] = ['label' => 'Medicine Checkups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medicine-checkup-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>