<?php

use app\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccessBit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Access Bits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-bit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'bit_pos',
            'key',
            'name',
            'comment:ntext',
            'order',
            'access_category_id',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bit_pos], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['confirm-delete', 'id' => $model->bit_pos], ['class' => 'btn btn-danger']) ?>
    </p>

</div>
