<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessMaskForm */

$this->title = 'Update Access Mask';
$this->params['breadcrumbs'][] = ['label' => 'Access Masks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="access-mask-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>