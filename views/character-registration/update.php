<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\StaffForm */

$this->title = "Update your character";
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rpn, 'url' => ['view', 'id' => $model->rpn]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("../staff/_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>