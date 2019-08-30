<?php

use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StaffBackground */

$this->title = $model->sid;
$this->params['breadcrumbs'][] = ['label' => 'Staff Backgrounds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-background-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_details', ['model' => $model]) ?>


</div>
