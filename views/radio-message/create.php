<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RadioMessage */

$this->title = 'Create Radio Message';
$this->params['breadcrumbs'][] = ['label' => 'Radio Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="radio-message-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render("_form", [
            "model" => $model,
        ]) ?>

        <div class="">
            <?= $this->render("_table", [
                "dataProvider" => $dataProvider,
                "searchModel"  => $searchModel,
            ]) ?>
        </div>
    </div>
</div>