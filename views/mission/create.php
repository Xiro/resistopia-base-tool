<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\form\MissionForm */
/* @var $staffSearch \app\models\search\StaffSearch */
/* @var $staffDataProvider \yii\data\ActiveDataProvider */

$this->title = 'Create Mission';
$this->params['breadcrumbs'][] = ['label' => 'Missions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
        "staffSearch"       => $staffSearch,
        "staffDataProvider" => $staffDataProvider,
    ]) ?>

</div>