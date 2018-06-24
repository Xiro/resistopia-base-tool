<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccessSecurityArea */

$this->title = 'Update Access Security Area';
$this->params['breadcrumbs'][] = ['label' => 'Access Security Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="access-security-area-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>