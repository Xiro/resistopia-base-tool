<?php

use app\helpers\Html;
use yii\data\ActiveDataProvider;

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

    <p>
        <?= nl2br($model->comment); ?>
    </p>
    <p>
        <?= nl2br($model->description); ?>
    </p>


    <h4>Members</h4>

    <?= $this->render("../staff/_table", [
        "dataProvider" => new ActiveDataProvider([
            'query' => $model->getStaff(),
        ]),
        "exclude"      => ["team", "action-delete"]
    ]) ?>

</div>
