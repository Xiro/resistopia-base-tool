<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Team */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="heading-btn-group pull-right">
        <?= Html::a(
            'Update',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a(
            'Delete',
            ['confirm-delete',
                'id' => $model->id],
            ['class' => 'btn btn-danger ajax-dialog', "data-size" => "sm"]
        ) ?>
            </span>
    </h1>

    <h4>Payments</h4>

    <?php $unpaidRp = $model->getUnpaidRP(); ?>
    <?php if($unpaidRp): ?>
    <p class="text-large"><?= $unpaidRp ?> RP have to be paid to <?= $model->name ?></p>
        <?= Html::a(
            "Pay $unpaidRp RP",
            ['team/pay', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
    <?php else: ?>
        <p class="text-large">No pending payments for <?= $model->name ?></p>
    <?php endif; ?>

    <h4>Members</h4>

    <?= $this->render("../staff/_staff-table", [
        "staffModels" => $model->staff,
        "exclude"     => ["team", "actions"]
    ]) ?>

</div>
