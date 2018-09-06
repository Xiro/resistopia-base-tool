<?php

use app\helpers\Html;
use yii\widgets\DetailView;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model app\models\MediFoamDistribution */

$this->title = "Ausgabe an " . $model->recipient_rpn;
$this->params['breadcrumbs'][] = ['label' => 'Medi Foam Distributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medi-foam-distribution-view container-fluid">

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
    $info["Empfänger"] = $model->recipient_rpn ? $model->recipient->nameWithRpn . ' ' . Html::a(
            Glyphicon::eye_open(),
            ['staff/view', 'id' => $model->recipient_rpn],
            ["class" => "ajax-dialog", "data-size" => "lg"]
        ) : 'n/a';
    $info["Ausgegeben von"] = $model->issued_by_rpn ? $model->issuedBy->nameWithRpn . ' ' . Html::a(
            Glyphicon::eye_open(),
            ['staff/view', 'id' => $model->issued_by_rpn],
            ["class" => "ajax-dialog", "data-size" => "lg"]
        ) : 'n/a';;
    $info["MK1 ausgegeben"] = $model->mk1_issued;
    $info["MK1 zurückgegeben"] = $model->mk1_returned;
    $info["Erstellt"] = $model->created ? date("d.m.Y H:i", strtotime($model->created)) : "n/a";
    ?>
    <div class="model-details row">
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