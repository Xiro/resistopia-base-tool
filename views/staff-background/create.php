<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StaffBackground */

$this->title = 'Create Staff Background';
$this->params['breadcrumbs'][] = ['label' => 'Staff Backgrounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-background-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>