<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessRightForm */

$this->title = 'Update Access Right';
$this->params['breadcrumbs'][] = ['label' => 'Access Rights', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="access-right-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>