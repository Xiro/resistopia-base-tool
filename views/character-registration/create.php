<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\forms\StaffForm */

$this->title = 'Create your character';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("../staff/_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>