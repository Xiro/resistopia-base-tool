<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessBitForm */

$this->title = 'Create Access Bit';
$this->params['breadcrumbs'][] = ['label' => 'Access Bits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-bit-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>