<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StaffBackground */

$this->title = 'Update Staff Background';
$this->params['breadcrumbs'][] = ['label' => 'Staff Backgrounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rpn, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-background-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>