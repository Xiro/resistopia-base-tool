<?php

use app\helpers\Html;
use mate\yii\widgets\Glyphicon;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $model app\models\Changelog */

$objectAsId = Inflector::camel2id($model->object);
$this->title = $model->object . "#" . $model->primary_key;
$this->params['breadcrumbs'][] = ['label' => 'Changelogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="changelog-view container-fluid">

    <h1>
        <?= Html::encode($this->title) . " " . Html::a(
            Glyphicon::eye_open(),
            [$objectAsId . '/view', 'id' => $model->primary_key],
            ["class" => "ajax-dialog", "data-size" => "lg"]
        ) ?>
    </h1>

    <?php
    $info = [];
    $info["Object"] = $model->object ? $model->object : "n/a";
    $info["Primary Key"] = $model->primary_key ? $model->primary_key : "n/a";
    $info["Type"] = $model->type ? $model->type : "n/a";

    $info["User"] = $model->user_id && $model->user ? $model->user->staff->rpn . " " . Html::a(
            Glyphicon::eye_open(),
            ['staff/view', 'id' => $model->user->staff->rpn],
            ["class" => "ajax-dialog", "data-size" => "lg"]
        ) : "n/a";
    $info["Time"] = $model->created ? date('d.m.Y H:i', strtotime($model->created)) : "n/a";
    $info["Hostname"] = $model->hostname ? $model->hostname : "n/a";

    ?>
    <div class="model-details row affiliations">
        <?php foreach ($info as $label => $value): ?>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-sm-6 detail-label">
                        <?= $label ?>
                    </div>
                    <div class="col-sm-6 detail-value">
                        <?= $value ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <div class="model-details-section">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <?= $this->render('_changes-table', [
                    'model' => $model
                ]) ?>
            </div>
        </div>
    </div>

</div>
