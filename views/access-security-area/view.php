<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccessSecurityArea */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Access Security Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-security-area-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'name',
            'access_bit_pos',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['confirm-delete', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </p>

</div>
