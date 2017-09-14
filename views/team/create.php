<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Team */
/* @var $staffSearch \app\models\search\StaffSearch */
/* @var $staffDataProvider \yii\data\ActiveDataProvider */

$this->title = 'Create Team';
$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render("_form", [
        "model" => $model,
        "staffSearch"       => $staffSearch,
        "staffDataProvider" => $staffDataProvider,
    ]) ?>

</div>