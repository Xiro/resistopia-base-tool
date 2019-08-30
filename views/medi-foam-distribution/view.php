<?php

use app\helpers\Html;
use yii\widgets\DetailView;
use mate\yii\widgets\Glyphicon;

/* @var $this yii\web\View */
/* @var $model app\models\MediFoamDistribution */

$this->title = "Ausgabe an " . $model->recipient_sid;
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
    $info["Empfänger"] = Html::staffLabel($model->recipient);
    $info["Ausgegeben von"] = Html::staffLabel($model->issuedBy);
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