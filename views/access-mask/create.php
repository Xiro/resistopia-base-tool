<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\forms\AccessMaskForm */

$this->title = 'Create Access Mask';
$this->params['breadcrumbs'][] = ['label' => 'Access Masks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-mask-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>