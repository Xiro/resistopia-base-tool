<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessBitForm */

$this->title = 'Update Access Bit';
$this->params['breadcrumbs'][] = ['label' => 'Access Bits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->bit_pos]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="access-bit-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>
    </div>
</div>