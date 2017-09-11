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
            'id',
            'rpn',
            'forename',
            'surname',
            'nickname',
            'height',
            'profession',
            'password',
            'created',
            'updated',
            'died',
            'call_sign',
            'is_blocked',
            'is_it',
            'company_id',
            'category_id',
            'speciality_id',
            'rank_id',
            'team_id',
            'blood_type_id',
            'eye_color_id',
            'staff_status_id',
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary ajax-dialog']) ?>
        <?= Html::a('Delete', ['confirm-delete', 'id' => $model->id], ['class' => 'btn btn-danger ajax-dialog']) ?>
    </p>

</div>
