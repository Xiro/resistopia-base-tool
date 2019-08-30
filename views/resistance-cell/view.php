<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ResistanceCell */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Resistance Cells', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resistance-cell-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'name',
            'latitude',
            'longitude',
            'order',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['confirm-delete', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </p>

</div>
