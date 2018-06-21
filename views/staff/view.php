<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Staff */

$this->title = $model->rpn;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'rpn',
            'forename',
            'surname',
            'nickname',
            'gender',
            'date_of_birth',
            'profession',
            'callsign',
            'height',
            'status_it',
            'status_be13',
            'status_alive',
            'status_in_base',
            'squat_number',
            'access_key_id',
            'rank_id',
            'base_category_id',
            'special_function_id',
            'company_id',
            'citizenship_id',
            'eye_color_id',
            'team_id',
            'created',
            'updated',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rpn], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['confirm-delete', 'id' => $model->rpn], ['class' => 'btn btn-danger']) ?>
    </p>

</div>
