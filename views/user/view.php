<?php

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = "User " . $model->rpn;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view container-fluid">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?= Html::a(
            'Update',
            ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a(
            'Delete',
            ['confirm-delete', 'id' => $model->id],
            ['class' => 'btn btn-danger ajax-dialog', "data-size" => "sm"]
        ) ?>
        </span>
    </h1>

    <?php
    $info = [];
    $info["RPN"] = $model->sid . ' ' . Html::a(
            Glyphicon::eye_open(),
            ['staff/view', 'id' => $model->sid],
            ["class" => "ajax-dialog", "data-size" => "lg"]
        );
    $info["Auth Key"] = $model->auth_key ? $model->auth_key : "n/a";
    $info["Access Token"] = $model->access_token ? $model->access_token : "n/a";
    $info["Token Expires"] = $model->token_expire ? date("d.m.Y H:i", strtotime($model->token_expire)) : "n/a";
    $info["Created"] = $model->created ? date("d.m.Y H:i", strtotime($model->created)) : "n/a";
    $info["Updated"] = $model->updated ? date("d.m.Y H:i", strtotime($model->updated)) : "n/a";
    ?>
    <div class="model-details row personal-info">
        <?php foreach ($info as $label => $value): ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-3 detail-label">
                        <?= $label ?>
                    </div>
                    <div class="col-sm-9 detail-value">
                        <?= $value ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
