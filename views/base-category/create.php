<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Section */

$this->title = 'Create section';
$this->params['breadcrumbs'][] = ['label' => 'Base Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>