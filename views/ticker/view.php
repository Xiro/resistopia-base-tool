<?php

use app\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ticker */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tickers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticker-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'message',
            'active',
            'order',
            'created',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['confirm-delete', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </p>

</div>
