<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mission */

$this->title = 'Delete Mission';
$this->params['breadcrumbs'][] = ['label' => 'Missions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mission-confirm-delete">

    <div class="container-fluid padding-large-vertical">

        <h2 style="margin-bottom: 10px"><?= Html::encode($this->title) ?></h2>

        <div class="text-large">
            <p class="padding-large-vertical">
                Are you sure you want to delete the Mission <b>'<?= $model->name ?>'</b>?
            </p>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::a(
                        "Yes",
                        ["delete", "id" => $model->id],
                        [
                            "class" => "btn btn-default btn-block",
                            "data"  => ["method" => "post"]
                        ]
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::a(
                        "No",
                        ["index"],
                        ["class" => "btn btn-default btn-block"]
                    ) ?>
                </div>
            </div>
        </div>

    </div>

</div>