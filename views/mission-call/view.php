<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MissionCall */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mission Calls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mission-call-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'RP',
            'FP',
            'zone',
            'scheduled_start',
            'scheduled_end',
            'fighter',
            'radio',
            'medic',
            'technician',
            'science',
            'guard',
            'vip',
            'mission_type_id',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary ajax-dialog']) ?>
        <?= Html::a('Delete', ['confirm-delete', 'id' => $model->id], ['class' => 'btn btn-danger ajax-dialog']) ?>
    </p>

</div>
