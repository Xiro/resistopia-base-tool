<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SpecialFunction */

$this->title = 'Create Special Function';
$this->params['breadcrumbs'][] = ['label' => 'Special Functions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-function-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>