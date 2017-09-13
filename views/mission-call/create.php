<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MissionCall */

$this->title = 'Create Mission Call';
$this->params['breadcrumbs'][] = ['label' => 'Mission Calls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mission-call-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
    ]) ?>

</div>