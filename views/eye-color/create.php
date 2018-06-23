<?php

use app\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EyeColor */

$this->title = 'Create Eye Color';
$this->params['breadcrumbs'][] = ['label' => 'Eye Colors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eye-color-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
        "model" => $model,
    ]) ?>
    </div>
</div>