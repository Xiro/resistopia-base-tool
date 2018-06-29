<?php

use app\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccessRight */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Access Rights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-right-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'key',
            'name',
            'comment:ntext',
            'order',
            'access_category_id',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['confirm-delete', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </p>

</div>
